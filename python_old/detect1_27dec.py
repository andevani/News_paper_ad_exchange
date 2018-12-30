# import the necessary packages
from shapedetector import ShapeDetector
import argparse
import imutils
import numpy as np
import cv2
import subprocess
import time
import numpy as np
import mysql.connector


cnx = mysql.connector.connect(user='root', password='',
                              host='127.0.0.1',
                              database='news')

cursor = cnx.cursor()
query = "INSERT INTO news.news3(filename,height,width,unique_id) " \
            "VALUES(%s,%s,%s,%s)"


# construct the argument parse and parse the arguments
ap = argparse.ArgumentParser()
ap.add_argument("-i", "--image", required=True,
	help="path to the input image")
ap.add_argument("-u", "--unique", required=True,
	help="path to the input image")
args = vars(ap.parse_args())
#print ("\n"+"uploads/"+args['image'])
image_args = "uploads/"+args['image']
print ("image_args.."+image_args)
print (args['unique'])

if args['image'].endswith('.pdf') or args['image'].endswith('.PDF'):
	print ("PDF file detected...........")
	print ("############################Converting PDF to PNG")
	process = subprocess.Popen("/usr/local/bin/pdftoppm -png %s > a.png" %image_args, stdout=subprocess.PIPE, stderr=subprocess.PIPE, shell=True)
	output, error = process.communicate()
	print ('error..'+str(error))
	args["image"] = "a.png"

reletive_area = 0
#print ("args....."+args['image'])
#image = cv2.imread(args["image"])
image = cv2.imread('a.png')
if image is None:
        print ("zero size image")
#image = cv2.imread()
#print ("next.....\n")
cv2.imwrite('image.png', image)
height, width,channels = image.shape
print ("height...."+str(height)+"..width..."+str(width))
#cv2.imwrite('required_files/image.png', 'uploads/20180226_3.PDF')
#print ("next.....\n")
resized = imutils.resize(image, width=1000)
#print ("ank......")
cv2.imwrite('image.png', resized)
#print ("ankd")
re_height, re_width, re_channels = resized.shape
print ("resized...height..."+str(re_height)+"..width.."+str(re_width))
print ("Total area = %s" %(re_height*re_width))
ratio = image.shape[0] / float(resized.shape[0])
'''
# convert the resized image to grayscale, blur it slightly,
# and threshold it
gray = cv2.cvtColor(resized, cv2.COLOR_BGR2GRAY)
blurred = cv2.bilateralFilter(gray, 3, 17, 17)
blurred = cv2.GaussianBlur(gray, (5,5), 0)
#thresh = cv2.threshold(blurred,128,255, cv2.THRESH_BINARY)[1]
#final = cv2.medianBlur(blurred, 3)
#kernel = np.ones((3,3), np.uint8)
#img_dilation = cv2.dilate(blurred, kernel, iterations=1)
thresh = cv2.Canny(blurred, 127, 255, 3)
blurred = cv2.GaussianBlur(thresh, (3,3), 0)
print ("ankur..")
*
#if (height*width) > 15000:
#        kernel = np.ones((1,1), np.uint8)
#        img_dilation = cv2.dilate(thresh, kernel, iterations=1)
#cv2.imshow("thresh",thresh)
#cv2.imshow("blurred",blurred)
#cv2.imshow("dialation",img_dilation)
#cv2.waitKey(11000)
'''

img_hsv=cv2.cvtColor(resized, cv2.COLOR_BGR2HSV)

# lower mask (0-10)
lower_red = np.array([0,200,200])
upper_red = np.array([1,255,255])
mask0 = cv2.inRange(img_hsv, lower_red, upper_red)

# upper mask (170-180)
lower_red = np.array([170,50,50])
upper_red = np.array([180,255,255])
mask1 = cv2.inRange(img_hsv, lower_red, upper_red)

# join my masks
#mask = mask0+mask1
mask = mask0

# set my output img to zero everywhere except my mask
#output_img = image.copy()
#output_img[np.where(mask==0)] = 0

# or your HSV image, which I *believe* is what you want
output_hsv = img_hsv.copy()
output_hsv[np.where(mask==0)] = 0

#cv2.imshow("a",output_hsv)




blurred = cv2.cvtColor(output_hsv, cv2.COLOR_HSV2BGR)
blurred = cv2.cvtColor(blurred, cv2.COLOR_BGR2GRAY)
#cv2.imshow("b",blurred)
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
			print ("creating at image_ankur/"+str(idx)+".png")
			cv2.imwrite('images/' + args['unique']+"_"+ str(idx) + '.png', new_img)
			db_filename = (args['unique']+"_"+str(idx)+".png")
			area1 = h*w
			print ("cropped..height.."+str((55*h)/(re_height+8))+"..width..."+str((40*w)/(re_width+20)))
			print ("filename..."+db_filename)
			reletive_area = reletive_area + area1
			#height1, width1, channels1 = new_img.shape
			print ("*****")
			#print (height1, width1)
			print ("Reletive height = %s Percentage" %round((h/height),3))
			db_height = (str(round(((55*h)/(re_height+8)),3)))
			db_width = (str(round(((40*w)/(re_width+20)), 3)))
			print ("Reletive width = %s Percentage" %round((w/width), 3))
			db_args = (db_filename,db_height,db_width,args['unique'])

			cursor.execute(query,db_args)

		# show the output image
			cv2.startWindowThread()
			#cv2.imshow("Image", resized)
			cv2.waitKey(11)
		#cv2.destroyAllWindows()
		#cv2.waitKey(1)
		#
print ("Total Reletive area = %s" %reletive_area)
cnx.commit()
cursor.close()
cnx.close()
cv2.destroyAllWindows()
cv2.waitKey(1)
