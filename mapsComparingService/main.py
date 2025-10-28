import json

import cv2
import sys
from os import path

from ColorsDict import ColorsDict
from MapsComparer import MapsComparer


if __name__ == '__main__':
    directory = path.dirname(__file__)
    mapsRoot = directory + '/../public/maps/'

    mc = MapsComparer()

    mapsUid = sys.argv[1]

    img1 = cv2.imread(mapsRoot + mapsUid + '-1.png')
    img2 = cv2.imread(mapsRoot + mapsUid + '-2.png')

    img1 = cv2.cvtColor(img1, cv2.COLOR_BGR2HSV)
    img2 = cv2.cvtColor(img2, cv2.COLOR_BGR2HSV)

    cd1 = ColorsDict()
    cd2 = ColorsDict()
    cd1.dict = [
        [[255, 106, 0], '1'],
        [[127, 0, 0], '1'],
        [[72, 0, 255], '1'],
        [[255, 0, 110], '1'],
        [[76, 255, 0], '1'],
        [[255, 216, 0], '1']
    ]
    cd2.dict = [
        [[255, 106, 0], '1'],
        [[178, 0, 255], '1'],
        [[72, 0, 255], '1'],
        [[255, 0, 110], '1'],
        [[76, 255, 0], '1'],
        [[255, 216, 0], '1']
    ]

    diff = mc.find_diff(img1, img2, cd1, cd2)
    rects = mc.get_rects(diff)

    print(json.dumps(rects))
