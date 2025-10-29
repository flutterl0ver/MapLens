import json

import cv2
import sys
from os import path

from ColorsDict import ColorsDict
from MapsComparer import MapsComparer


def to_rgb(hex_color):
    hex_color = hex_color.lstrip('#')
    return [int(hex_color[i:i + 2], 16) for i in (0, 2, 4)]


if __name__ == '__main__':
    directory = path.dirname(__file__)
    mapsRoot = directory + '/../public/maps/'
    legendsRoot = directory + '/../public/legends/'

    mc = MapsComparer()

    mapsUid = sys.argv[1]
    legendId = sys.argv[2]

    # mapsUid = 'real2'
    # legendId = '019a2eb2-cbc7-7361-9c48-a38ff21ebc12'

    cd1 = ColorsDict()
    cd2 = ColorsDict()

    legendString = open(legendsRoot + F'{legendId}.txt', 'r').read()
    legend = json.loads(legendString)
    for entry in legend:
        cd1.dict.append([to_rgb(entry[0]), entry[2]])
        cd2.dict.append([to_rgb(entry[1]), entry[2]])

    img1 = cv2.imread(mapsRoot + mapsUid + '-1.png')
    img2 = cv2.imread(mapsRoot + mapsUid + '-2.png')

    img1 = cv2.cvtColor(img1, cv2.COLOR_BGR2HSV)
    img2 = cv2.cvtColor(img2, cv2.COLOR_BGR2HSV)

    diff = mc.find_diff(img1, img2, cd1, cd2)
    rects = mc.get_rects(diff)

    print(json.dumps(rects))
