import  serial
import MySQLdb
conn = MySQLdb.connect(host="localhost", user="root", passwd="name", db="attendance")

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
	id = src.read();
	if(isinstance(id,int)):
		roll_no = src.read();
		if(isinstance(roll_no, int)):
			query = "INSERT INTO `student_id` VALUES(roll_no, id)";
			myc.execute(query)
			conn.commit()
conn.close()
