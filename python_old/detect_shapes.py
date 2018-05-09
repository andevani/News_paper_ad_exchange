# import the necessary packages
from shapedetector import ShapeDetector
import argparse
import imutils
import numpy as np
import cv2
import subprocess

# construct the argument parse and parse the arguments
ap = argparse.ArgumentParser()
ap.add_argument("-i", "--image", required=True,
	help="path to the input image")
args = vars(ap.parse_args())
print (args['image'])

if args['image'].endswith('.pdf') or args['image'].endswith('.PDF'):
	print ("PDF file detected...........")
	print ("############################Converting PDF to PNG")
	process = subprocess.Popen("pdftoppm -png %s > a.png" %args['image'], stdout=subprocess.PIPE, shell=True)
	output, error = process.communicate()
	args["image"] = "a.png"

reletive_area = 0

# load the image and resize it to a smaller factor so that
# the shapes can be approximated better
image = cv2.imread(args["image"])
cv2.imwrite('image.png', image)
resized = imutils.resize(image, width=6400)
cv2.imwrite('image.png', resized)
height, width, channels = resized.shape
print ("Total area = %s" %(height*width))
ratio = image.shape[0] / float(resized.shape[0])

# convert the resized image to grayscale, blur it slightly,
# and threshold it
gray = cv2.cvtColor(resized, cv2.COLOR_BGR2GRAY)
blurred = cv2.bilateralFilter(gray, 3, 17, 17)
blurred = cv2.GaussianBlur(gray, (3,3), 0)
#thresh = cv2.threshold(blurred,128,255, cv2.THRESH_BINARY)[1]
#final = cv2.medianBlur(blurred, 3)
#kernel = np.ones((3,3), np.uint8)
#img_dilation = cv2.dilate(blurred, kernel, iterations=1)
thresh = cv2.Canny(blurred, 120, 255, 3)
blurred = cv2.GaussianBlur(thresh, (3,3), 0)
#if (height*width) > 15000:
#        kernel = np.ones((1,1), np.uint8)
#        img_dilation = cv2.dilate(thresh, kernel, iterations=1)
#cv2.imshow("thresh",thresh)
#cv2.imshow("blurred",blurred)
#cv2.imshow("dialation",img_dilation)
#cv2.waitKey(11000)

# find contours in the thresholded image and initialize the
# shape detector
cnts = cv2.findContours(blurred.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
#cnts = cv2.findContours(img_dilation.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
cnts = cnts[0] if imutils.is_cv2() else cnts[1]
sd = ShapeDetector()
idx = 0
# loop over the contours
for c in cnts:
	# compute the center of the contour, then detect the name of the
	# shape using only the contour
	M = cv2.moments(c)
	cX = int((M["m10"] / (M["m00"] + 1e-7)) * ratio)
	cY = int((M["m01"] / (M["m00"] + 1e-7)) * ratio)
	if (1 == 1):
		(shape, x, y, w, h) = sd.detect(c)
		#print ("s d d f f"+shape+"shape.."+str(x)+"x."+str(y)+"y."+str(w)+"w."+str(h))

	#if (shape == "rectangle"):
	# multiply the contour (x, y)-coordinates by the resize ratio,
	# then draw the contours and the name of the shape on the image
		c = c.astype("float")
	#c *= ratio
		c = c.astype("int")
	#cv2.drawContours(resized, [c], -1, (0,255,0), 2)
		if (shape == "rectangle" or shape == "square"):
			#cv2.drawContours(resized, [c], -1, (0,255,0), 2)
			#cv2.putText(resized, "news detected", (cX, cY), cv2.FONT_HERSHEY_SIMPLEX,
			#	0.5, (255, 0, 0 ), 2)
			idx = idx+1
			new_img=resized[y:y+h,x:x+w]
			cv2.imwrite(str(idx) + '.png', new_img)
			area1 = h*w
			reletive_area = reletive_area + area1
			#height1, width1, channels1 = new_img.shape
			print ("*****")
			#print (height1, width1)
			print ("Reletive height = %s Percentage" %round((h/height),3))
			print ("Reletive width = %s Percentage" %round((w/width), 3))

		# show the output image
			cv2.startWindowThread()
			#cv2.imshow("Image", resized)
			cv2.waitKey(11)
		#cv2.destroyAllWindows()
		#cv2.waitKey(1)
		#
print ("Total Reletive area = %s" %reletive_area)
cv2.destroyAllWindows()
cv2.waitKey(1)
