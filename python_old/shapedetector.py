# import the necessary packages
import cv2

class ShapeDetector:
	def __init__(self):
		pass

	def detect(self, c):
		# initialize the shape name and approximate the contour
		shape = "unidentified"
		x = 0
		y = 0
		w = 0
		h = 0
		peri = cv2.arcLength(c, True)
		approx = cv2.approxPolyDP(c, 0.08 * peri, True)
		# if the shape is a triangle, it will have 3 vertices
		if len(approx) == 3:
			shape = "triangle"
			#print ("detecting triangle")

		# if the shape has 4 vertices, it is either a square or
		# a rectangle
		elif len(approx) == 4:
			# compute the bounding box of the contour and use the
			# bounding box to compute the aspect ratio
			(x, y, w, h) = cv2.boundingRect(approx)
			ar = w / float(h)

			# a square will have an aspect ratio that is approximately
			# equal to one, otherwise, the shape is a rectangle
			#print ("###########ankur...w and h.."+str(w)+",,"+str(h))
			if (w * h) > 3000 and (w * h) < 500000000:
				#shape = "square" if ar >= 0.95 and ar <= 1.05 else "rectangle"
				shape = "square"
				return shape, x, y, w, h
			else:
				return ("shape",1,1,1,1)

		# if the shape is a pentagon, it will have 5 vertices
		elif len(approx) == 5:
			shape = "pentagon"
			#print ("Detecting penatgon...")

		# otherwise, we assume the shape is a circle
		else:
			shape = "circle"

		# return the name of the shape
#		if shape is None:
#			shape = "shape"
		return ("shape",1,1,1,1)
