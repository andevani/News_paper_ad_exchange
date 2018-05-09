# import the necessary packages
from shapedetector import ShapeDetector
import argparse
import imutils
import numpy as np
import cv2

# construct the argument parse and parse the arguments
ap = argparse.ArgumentParser()
ap.add_argument("-i", "--image", required=True,
	help="path to the input image")
args = vars(ap.parse_args())

# load the image and resize it to a smaller factor so that
# the shapes can be approximated better
image = cv2.imread(args["image"])
resized = imutils.resize(image, width=1200)
ratio = image.shape[0] / float(resized.shape[0])

crop = resized[1240+426,896+275]
cv2.imshow("crop",crop)
cv2.waitKey(11000)
cv2.destroyAllWindows()
cv2.waitKey(1)
