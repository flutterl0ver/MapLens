import json.encoder
import cv2
import sys
from os import path
from MapsComparer import MapsComparer


if __name__ == '__main__':
    directory = path.dirname(__file__)
    mapsRoot = directory + '/../public/maps/'

    mc = MapsComparer()

    mapsUid = sys.argv[1]

    img1 = cv2.imread(mapsRoot + mapsUid + '-1.png')
    img2 = cv2.imread(mapsRoot + mapsUid + '-2.png')

    result = mc.find_diff(img1, img2)
    output = []

    for cont in result:
        output.append((
            mc.get_rect(cont[0]),
            mc.get_rect(cont[1])
        ))
    #     cv2.drawContours(img1, cont[0], -1, (0, 0, 0), 2)
    #     cv2.drawContours(img2, cont[1], -1, (0, 0, 0), 2)
    #
    # cv2.imshow("img1", img1)
    # cv2.imshow("img2", img2)
    #
    # cv2.waitKey(0)
    print(json.dumps(output))
