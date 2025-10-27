import cv2


class MapsComparer:
    def resize_maps(self, img1, img2):
        pass

    def find_diff(self, img1, img2):
        cn1 = cv2.Canny(img1, 255 / 3, 255)
        cn2 = cv2.Canny(img2, 255 / 3, 255)

        cont1, h1 = cv2.findContours(cn1, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE)
        cont2, h2 = cv2.findContours(cn2, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE)

        result = []

        for cont in zip(cont1, cont2):
            if len(cont[0]) != len(cont[1]) or (cont[0] != cont[1]).any():
                result.append(cont)
            elif (self.get_color(img1, cont[0]) != self.get_color(img2, cont[1])).any():
                result.append(cont)

        return result

    def get_color(self, img, cont):
        min_coords = cont[0][0]
        for coord in cont:
            if coord[0][0] < min_coords[0]:
                min_coords = coord[0]

        return img[min_coords[1]][min_coords[0] + 1]

    def get_rect(self, cont):
        min_coords = [cont[0][0][0], cont[0][0][1]]
        max_coords = [cont[0][0][0], cont[0][0][1]]
        for coord in cont:
            min_coords[0] = int(min(min_coords[0], coord[0][0]))
            min_coords[1] = int(min(min_coords[1], coord[0][1]))
            max_coords[0] = int(max(max_coords[0], coord[0][0]))
            max_coords[1] = int(max(max_coords[1], coord[0][1]))
        return min_coords, max_coords
