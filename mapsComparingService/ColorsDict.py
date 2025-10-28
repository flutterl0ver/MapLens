import cv2
import numpy as np

class ColorsDict:
    def __init__(self):
        self.dict = []

    def to_hsv(self):
        result = ColorsDict()
        for kvp in self.dict:
            arr = np.array([[kvp[0]]], dtype='uint8')
            result.dict.append([cv2.cvtColor(arr, cv2.COLOR_RGB2HSV)[0][0].tolist(), kvp[1]])
        return result
