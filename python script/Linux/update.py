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

ids = []


# first of all take the instructure ID
instructure_id = 113
while 1:
	id = src.readline()
	print id
	try:
		int(id)
	except ValueError:
		x = 0
	else:
		id = int(id)
		if id == instructure_id:
			query = "UPDATE `esc101` SET class_conducted = class_conducted  + 1"
			myc.execute(query)
			conn.commit()
			print "UPdate"
			while 1:
				id = src.readline()
				try:
					int(id)
				except ValueError:
					x = 0
				else:
					if id in ids:
						continue
					ids.append(id)
					print id
					id = int(id)
					query = ("SELECT `roll_no` FROM `student_id` WHERE id = %d ") % (id)
					myc.execute(query)
					id = myc.fetchone()
					query = ("UPDATE `esc101` SET class_attended = class_attended  + 1  WHERE id = %s ") % (id)
					myc.execute(query)
					conn.commit()
					query = "UPDATE `esc101` SET percentage = (class_attended/class_conducted)*100 "
					myc.execute(query)
					conn.commit()
conn.close()
