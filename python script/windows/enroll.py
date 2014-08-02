import  serial
import mysql.connector
conn = mysql.connector.connect( user="root", password="", host="localhost", database="attendance")

myc = conn.cursor()

# for linux
src = serial.Serial('/dev/ttyACM0', 9600)


# we can find the path by
# but remove the arduino first
# ls /dev/tty*
# now plugIn arduino and run the command again
# if there is any change in the result then that is our port name

# first of all take the instructure ID

while 1:
	id = src.readline();
	try:
		int(id)
	except ValueError:
		x = 0
	else:
		id = int(id)
		roll_no = src.readline();
		try:
			int(roll_no)
		except ValueError:
			x = 0
		else:
			roll_no = int(roll_no)
			query = "INSERT INTO `student_id` VALUES(roll_no, id)";
			myc.execute(query)
			conn.commit()
conn.close()
