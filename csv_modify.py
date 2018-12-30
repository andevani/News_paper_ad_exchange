import csv
import sys

input_file = sys.argv[1]

out_file = open("out_modified.csv","w+")
in_file = open(input_file,"r")

for line in in_file:
	line = line.split(',')
	length = len([x for x in line if x == ''])
	#print length
	line1 = str(line)
	if (length <= 14):
		line1 = [x for x in line if x != '']
		line1 = str(line1)
		out_file.write(line1.replace("'","").replace("[","").replace("]","")[:-4])
		out_file.write('\n')
