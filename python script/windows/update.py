import  serial
import mysql.connector
conn = mysql.connector.connect( user="root", password="", host="localhost", database="attendance")

myc = conn.cursor()

# for windows
src = serial.Serial('COM9', 9600)


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
