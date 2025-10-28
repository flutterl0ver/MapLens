import cv2
import numpy as np
from scipy.spatial import cKDTree

from ColorsDict import ColorsDict


class MapsComparer:
    def get_mask(self, img, color):
        return cv2.inRange(img, *self.approx_color(color, 1.05))

    def find_diff(self, img1, img2, c_dict1: ColorsDict, c_dict2: ColorsDict):
        c_dict1 = c_dict1.to_hsv()
        c_dict2 = c_dict2.to_hsv()

        img1 = self.remove_text(img1)
        img2 = self.remove_text(img2)

        diff = np.zeros_like(img1)

        for index, kvp in enumerate(c_dict1.dict):
            c1 = np.array(kvp[0], dtype='uint8')
            c2 = np.array(c_dict2.dict[index][0], dtype='uint8')

            mask1 = self.get_mask(img1, c1)
            mask2 = self.get_mask(img2, c2)

            mask1 = self.extend_mask(mask1, 20)
            mask2 = self.extend_mask(mask2, 20)

            mask1 = cv2.blur(mask1, (30, 30))
            mask2 = cv2.blur(mask2, (30, 30))

            self.find_masks_diff(mask1, mask2, diff)
        return diff

    def find_masks_diff(self, mask1, mask2, diff):
        threshold = 90
        for x in range(mask1.shape[0]):
            for y in range(mask1.shape[1]):
                c1 = mask1[x][y]
                c2 = mask2[x][y]
                if abs(int(c1) - int(c2)) >= threshold:
                    diff[x][y] = 255

    def extend_mask(self, mask, amount):
        kern = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (amount, amount))
        return cv2.dilate(mask, kern, iterations=1)

    def get_rects(self, diff):
        cn = cv2.Canny(diff, 255 / 3, 255)
        conts, h = cv2.findContours(cn, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE)
        result = []
        for cont in conts:
            result.append(self.get_rect(cont))
        return result

    def get_masks(self, img, c_dict: ColorsDict):
        c_dict = c_dict.to_hsv()
        masks = []
        for kvp in c_dict.dict:
            color = np.array(kvp[0], dtype='uint8')
            masks.append(self.get_mask(img, color))
        return np.array(masks)

    def get_rect(self, cont):
        min_coords = [cont[0][0][0], cont[0][0][1]]
        max_coords = [cont[0][0][0], cont[0][0][1]]
        for coord in cont:
            min_coords[0] = int(min(min_coords[0], coord[0][0]))
            min_coords[1] = int(min(min_coords[1], coord[0][1]))
            max_coords[0] = int(max(max_coords[0], coord[0][0]))
            max_coords[1] = int(max(max_coords[1], coord[0][1]))
        return min_coords, max_coords

    def cut_mask(self, img, mask):
        height, width = img.shape[:2]
        y_coords, x_coords = np.mgrid[0:height, 0:width]

        non_target_mask = (mask == 0)
        non_target_points = np.column_stack((
            y_coords[non_target_mask],
            x_coords[non_target_mask]
        ))

        target_points = np.column_stack((
            y_coords[mask > 0],
            x_coords[mask > 0]
        ))

        if len(non_target_points) > 0 and len(target_points) > 0:
            tree = cKDTree(non_target_points)

            distances, indices = tree.query(target_points, k=1)

            for i, (y, x) in enumerate(target_points):
                nearest_y, nearest_x = non_target_points[indices[i]]
                img[y, x] = img[nearest_y, nearest_x]

    def remove_text(self, img):
        gray = cv2.cvtColor(img, cv2.COLOR_HSV2BGR)
        gray = cv2.cvtColor(gray, cv2.COLOR_BGR2GRAY)
        ret, wmask = cv2.threshold(gray, 240, 255, cv2.THRESH_BINARY)
        ret, bmask = cv2.threshold(gray, 20, 255, cv2.THRESH_BINARY)

        bmask = cv2.bitwise_not(bmask)

        bmask = self.extend_mask(bmask, 10)
        wmask = self.extend_mask(wmask, 10)

        if np.sum(bmask) == 0 and np.sum(wmask) == 0:
            return img.copy()

        result = img.copy()

        self.cut_mask(result, bmask)
        self.cut_mask(result, wmask)

        return result

    def approx_color(self, color, d):
        min_color = color.copy()
        max_color = color.copy()
        for i in range(len(color)):
            min_color[i] /= d

            if max_color[i] * d <= 255:
                max_color[i] *= d
            else:
                max_color[i] = 255
        return min_color, max_color
