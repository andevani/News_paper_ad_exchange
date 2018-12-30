print ("before subprocess")
import subprocess
import argparse


print ("now in pdftoppm.py file..")
ap = argparse.ArgumentParser()
ap.add_argument("-i", "--image", required=True,
	help="path to the input image")
ap.add_argument("-u", "--unique", required=True,
        help="path to the input image")
args = vars(ap.parse_args())

print("dndn"+args['image'])

updated_b = args['unique']+"_b.png"

image_args = "uploads/"+args['image']
print ("image_args.."+image_args)

print ("PDF file detected...........")
print ("############################Converting PDF to PNG")
process = subprocess.Popen("/usr/bin/pdftoppm -png "+image_args+" > "+updated_b, stdout=subprocess.PIPE, stderr=subprocess.PIPE, shell=True)
output, error = process.communicate()
print ('error..'+str(error))
