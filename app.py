from flask import Flask, render_template, json, request
from flaskext.mysql import MySQL
from werkzeug import generate_password_hash, check_password_hash

mysql = MySQL()
app = Flask(__name__)

# MySQL configurations
app.config['MYSQL_DATABASE_USER'] = 'root'
app.config['MYSQL_DATABASE_PASSWORD'] = 'melo8946'
app.config['MYSQL_DATABASE_DB'] = 'BucketList'
app.config['MYSQL_DATABASE_HOST'] = '127.0.0.1'
mysql.init_app(app)
#-------------------------------------------------------------------------------
@app.route('/')
def main():
	#return "Welcome!"
	return render_template('ProjectPage.html')
	#return render_template('ProjectPage.html')

# Creating a Sign In interface
@app.route('/showSignIn')
def showSignIn():
	return render_template('checkout.html')

# Creating a Signup interface
@app.route('/showSignUp')
def showSignUp():
	return render_template('signup.html')

# Implementing the Signup method
@app.route('/signUp',methods=['POST','GET'])
def SignUp():
	try:
		#Read the posted values from the UI
		_name = request.form['inputName']
		_email = request.form['inputEmail']
		_password = request.form['inputPassword']

		# validate the received values
		if _name and _email and _password:

			# All Good, let's call mysql

			conn = mysql.connect()
			cursor = conn.cursor()
			_hashed_password = generate_password_hash(_password)
			cursor.callproc('sp_createUser',(_name,_email,_hashed_password))
			data = cursor.fetchall()

			if len(data) is 0:
				conn.commit()
				return json.dumps({'message':'User created successfully !'})
			else:
				return json.dumps({'error':str(data[0])})
				print('Not working')

		else:
			return json.dumps({'html':'<span>Enter the required fields</span>'})
			print('Enter the required fields')
	except Exception as e:
		return json.dumps({'error':str(e)})
	finally:
		cursor.close()
		conn.close()
#------------------------------------------------------------------------------

if __name__=="__main__":
	app.run(port=5000)
