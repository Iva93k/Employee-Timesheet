**Employee timesheet**
----
Api documentation for employee timesheet project.

Basic Auth is required! Basic Auth is an authorization type that requires a verified username (in this case: email) and password to access a data resource.

Allowed HTTPs requests:

	GET			: Get a company or employee

	PUT/POST	: Update employee profile

Description of usual server responses:

	200 (OK)					- the request was successful,
	
	400 (Bad Request)			- the request could not be understood or was missing required parameters,
	
	401 (Unauthorized)			- authentication failed or user does not have permissions for requested operation,
	
	404 (Not Found)				- resource was not found,
	
	500 (Internal Server Error)	- server error


  
*  **Employee**

	Respresents employee details.

	Employee attributes: 

		id (integer),

		first_name (string),

		last_name (string),

		title (string),

		email (string),

		phone (string),

		address (string),

		city (string),

		birthdate (date),

		contract_date (date),

		uid (string),
		
		gender (integer)
   

* **Company**

	Respresents company details.

	Company attributes:

		name (string),
		
		address (string),
		
		city (string),
		
		phone_number (string),
		
		fax (string), 
		
		email (string),
		
		web (string),
		
		contact_person (string),
		
		id_number (string),
		
		tax_number (string),
		
		lunch_break (integer),
		
		start_working_time (time),
		
		end_working_time (time)

* **Work day types**

	Respresents work day types details.
	
	Work day types attributes:
	
		id (integer),
	
		code (string),
		
		title (string),
		
		description (text),
		
		check_in_enabled (boolean),
		
		color (string),
		
		payed (boolean)
		
* **Work day logs**

	Respresents work day logs details.
	
	Work day logs attributes:
	
		id (integer),
	
		work_day (date),
		
		check_in_time (time),
		
		check_out_time (time),
		
		work_day_type_id (integer)
		

**Profile**
----
Returns json data about a single employee.
* **URL**

		/api/employees/profile.json

* **Method:**

  `GET`

* **Success Response:**

  * **Code:** 200
  
   * **Content:** 
	```json
		{
			"message": "OK",
			"data": {
				"id": 5,
				"first_name": "Ivana",
				"last_name": "Kovacevic",
				"title": "intern",
				"email": "ivana1@gmail.com",
				"phone": "123456",
				"address": "Address",
				"city": "City",
				"birthdate": "29.10.1993",
				"contract_date": "01.07.2019",
				"uid": "1a",
				"gender": "Female",
				"photos": {
					"small": "/files/employees/photo_name/904672f1-0f2e-4834-92b9-e57f78bbb042/small_Desert.jpg",
					"medium": "/files/employees/photo_name/904672f1-0f2e-4834-92b9-e57f78bbb042/medium_Desert.jpg"
				}
			}
		}
	```
 
* **Error Response:**

  * **Code:** 401 UNAUTHORIZED
  
   * **Content:**
	```json
		{
			"message": "Unauthorized",
			"url": "\/api\/employees\/profile.json",
			"code": 401,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Auth\\BasicAuthenticate.php",
			"line": 96
		}
	```

  OR

  * **Code:** 404 NOT FOUND
  
  *  **Content:** 
	```json
		{
			"message": "Action EmployeesController::pprofile() could not be found, or is not accessible.",
			"url": "\/api\/employees\/pprofile.json",
			"code": 404,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Controller\\Controller.php",
			"line": 600
		}
	```


**Update Profile**
----
Update employee profile data

* **URL**

		/api/employees/update.json

* **Method:**
  
	`POST` | `PUT`
	
* **Data Params**

	- first_name
	- last_name
	- title
	- email
	- password
	- phone
	- address
	- city
	- birthdate
	- gender

* **Success Response:**

  * **Code:** 200
  
  * **Content:** 
	```json
		{
			"message": "Profile successefully updated!",
			"data": {
				"id": 5,
				"first_name": "Ivana",
				"last_name": "Kovacevic",
				"title": "intern",
				"photo_name": "Desert.jpg",
				"photo_path": "904672f1-0f2e-4834-92b9-e57f78bbb042",
				"email": "ivana1@gmail.com",
				"phone": "123456",
				"address": "Address",
				"city": "City",
				"birthdate": "29.10.1993",
				"contract_date": "01.07.2019",
				"uid": "1a",
				"gender": "Female"
			}
		}
	```
 
* **Error Response:**

  * **Code:** 401 UNAUTHORIZED
  
  * **Content:** 
	```json
		{
			"message": "Unauthorized",
			"url": "\/api\/employees\/update.json",
			"code": 401,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Auth\\BasicAuthenticate.php",
			"line": 96
		}
	```
  OR

  * **Code:** 404 NOT FOUND
  
  * **Content:**
	```json
		{
			"message": "Action EmployeesController::uupdate() could not be found, or is not accessible.",
			"url": "\/api\/employees\/uupdate.json",
			"code": 404,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Controller\\Controller.php",
			"line": 600
		}
	```

**Forgot password**
----
Returns new password for employee - sends a new password to the given email.

* **URL**

		/api/employees/forgot-password.json

* **Method:**
  
	`POST` | `PUT`

* **Data Params**

	- email

* **Success Response:**

  * **Code:** 200
  
  * **Content:** 
	```json
		{
			"message": "New password has been sent to the given email!",
			"data": []
		}
	```
 
* **Error Response:**

  * **Code:** 404 NOT FOUND
  
  * **Content:**
	```json
		{
			"message": "Action EmployeesController::forgot.password() could not be found, or is not accessible.",
			"url": "/api/employees/forgot.password.json",
			"code": 404,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Controller\\Controller.php",
			"line": 600
		}
	```
	
	OR
	
  * **Content:**
	```json
		{
			"message": "Email address does not exist, or employee with this email address is inactive. Please, try again!",
			"data": []
		}
	```
	
**View**
----
Returns json data about a company.

* **URL**

		/api/companies/view.json

* **Method:**

  `GET`
  
*  **URL Params**

	None

* **Success Response:**

  * **Code:** 200
  
  * **Content:** 
	```json
		{
			"message": "OK",
			"data": {
				"name": "Company",
				"address": "Address",
				"city": "City",
				"phone_number": "123456789",
				"fax": "123456789",
				"email": "hello@company.com",
				"web": "company.com",
				"contact_person": "John Doe",
				"id_number": "123456789",
				"tax_number": "987654321",
				"lunch_break": 30,
				"start_working_time": "08:00",
				"end_working_time": "16:30"
			}
		}
	```
 
* **Error Response:**

  * **Code:** 401 UNAUTHORIZED
  
  * **Content:** 
	```json
		{
			"message": "Unauthorized",
			"url": "/api/companies/view.json",
			"code": 401,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Auth\\BasicAuthenticate.php",
			"line": 96
		}
	```

  OR

  * **Code:** 404 NOT FOUND
  
  * **Content:** 
	```json
		{
			"message": "Action CompaniesController::viewv() could not be found, or is not accessible.",
			"url": "/api/companies/viewv.json",
			"code": 404,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Controller\\Controller.php",
			"line": 600
		}
	```
	
**Index**
----
Returns list of all items - json data about every work day type.

* **URL**

		/api/work-day-types/index.json

* **Method:**

  `GET`
  
*  **URL Params**

	- check_in_enabled => 0 | 1 (optional)

* **Success Response:**

  * **Code:** 200
  
  * **Content:** 
	```json
		{
			"message": "OK",
			"data": [
				{
					"id": 25,
					"code": "R",
					"title": "Daily working time",
					"check_in_enabled": true,
					"description": "",
					"color": "#e06631",
					"payed": true
				},
				{
					"id": 26,
					"code": "P",
					"title": "Business trip",
					"check_in_enabled": true,
					"description": "Business trip",
					"color": "#eeeeee",
					"payed": true
				},
				{
					"id": 50,
					"code": "M",
					"title": "m",
					"check_in_enabled": true,
					"description": "test",
					"color": "#eeeeee",
					"payed": false
				},
				{
					"id": 57,
					"code": "V",
					"title": "Weekend",
					"check_in_enabled": true,
					"description": "",
					"color": "#2cde89",
					"payed": false
				},
				{
					"id": 77,
					"code": "I",
					"title": "i",
					"check_in_enabled": true,
					"description": "i",
					"color": "#3a4eb5",
					"payed": false
				}
			]
		}
	```
 
* **Error Response:**

  * **Code:** 401 UNAUTHORIZED
  
  * **Content:** 
	```json
		{
			"message": "Unauthorized",
			"url": "/api/work-day-types/index.json",
			"code": 401,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Auth\\BasicAuthenticate.php",
			"line": 96
		}
	```

  OR

  * **Code:** 404 NOT FOUND
  
  * **Content:** 
	```json
		{
			"message": "Action WorkDayTypesController::iindex() could not be found, or is not accessible.",
			"url": "/api/work-day-types/iindex.json",
			"code": 404,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Controller\\Controller.php",
			"line": 600
		}
	```

**checkIn**
----
Creates new work day log and sets the check_in_time to current time.

* **URL**

		/api/work-day-logs/checkin.json

* **Method:**

  `POST`
  
* **Data Params**

	- work_day_type_id (optional)

* **Success Response:**

  * **Code:** 200
  
  * **Content:** 
	```json
		{
			"message": "Log successfully added!",
			"data": {
				"work_day": "18.09.2019",
				"check_in_time": "16:07",
				"check_out_time": "00:00",
				"work_day_type_id": 25,
				"year": "2019",
				"month": "9",
				"day": "18",
				"month_name": "September",
				"time_spent": "00:00"
			}
		}
	```
 
* **Error Response:**

  * **Code:** 401 UNAUTHORIZED
  
  * **Content:** 
	```json
		{
			"message": "Unauthorized",
			"url": "/api/work-day-logs/checkin.json?work_day_type_id=25",
			"code": 401,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Auth\\BasicAuthenticate.php",
			"line": 96
		}
	```

  OR

  * **Code:** 404 NOT FOUND
  
  * **Content:** 
	```json
		{
			"message": "Action WorkDayLogsController::checkiin() could not be found, or is not accessible.",
			"url": "/api/work-day-logs/checkiin.json",
			"code": 404,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Controller\\Controller.php",
			"line": 600
		}
	```

  OR
  
  * **Content:** 
	```json
		{
			"message": "Work day log already exists!",
			"data": {
				"work_day_type_id": 25,
				"work_day": "18.09.2019",
				"check_in_time": "15:14",
				"check_out_time": "00:00",
				"year": "2019",
				"month": "9",
				"day": "18",
				"month_name": "September",
				"time_spent": "00:00"
			}
		}
	```
  
	
**checkOut**
----
Updates the work day log - sets the check_out_time to current time.

* **URL**

		/api/work-day-logs/checkout.json

* **Method:**

  `POST`

* **Success Response:**

  * **Code:** 200
  
  * **Content:** 
	```json
		{
			"message": "Log successfully updated!",
			"data": {
				"work_day_type_id": 25,
				"work_day": "18.09.2019",
				"check_in_time": "16:04",
				"check_out_time": "16:06",
				"year": "2019",
				"month": "9",
				"day": "18",
				"month_name": "September",
				"time_spent": "00:02"
			}
		}
	```
 
* **Error Response:**

  * **Code:** 401 UNAUTHORIZED
  
  * **Content:** 
	```json
		{
			"message": "Unauthorized",
			"url": "/api/work-day-logs/checkout.json",
			"code": 401,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Auth\\BasicAuthenticate.php",
			"line": 96
		}
	```

  OR

  * **Code:** 404 NOT FOUND
  
  * **Content:** 
	```json
		{
			"message": "Action WorkDayLogsController::checkout1() could not be found, or is not accessible.",
			"url": "/api/work-day-logs/checkout1.json",
			"code": 404,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Controller\\Controller.php",
			"line": 600
		}
	```
	
OR

* **Content:** 
	```json
		{
			"message": "You are already checked out!",
			"data": {
				"work_day_type_id": 25,
				"work_day": "16.09.2019",
				"check_in_time": "10:48",
				"check_out_time": "11:22",
				"year": "2019",
				"month": "9",
				"day": "16",
				"month_name": "September",
				"time_spent": "00:04"
			}
		}
	```


	
**list**
----
Returns monthly work day logs for logged user.

* **URL**

		/api/work-day-logs/list.json

* **Method:**

  `GET`
  
*  **URL Params**

	- month =>  (Optional; By defualt, month is the current month)
	- year	=>	(Optional; By defualt, year is the current year)


* **Success Response:**

  * **Code:** 200
  
  * **Content:** 
	```json
		{
			"message": "OK",
			"data": [
				{
					"work_day_type_id": 57,
					"work_day": "01.09.2019",
					"check_in_time": "08:00",
					"check_out_time": "16:30",
					"year": "2019",
					"month": "9",
					"day": "1",
					"month_name": "September",
					"time_spent": null
				},
				{
					"work_day_type_id": 25,
					"work_day": "02.09.2019",
					"check_in_time": "08:00",
					"check_out_time": "00:00",
					"year": "2019",
					"month": "9",
					"day": "2",
					"month_name": "September",
					"time_spent": "06:38"
				}
			]
		}
	```
 
* **Error Response:**

  * **Code:** 401 UNAUTHORIZED
  
  * **Content:** 
	```json
		{
			"message": "Unauthorized",
			"url": "/api/work-day-logs/list.json",
			"code": 401,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Auth\\BasicAuthenticate.php",
			"line": 96
		}
	```

  OR

  * **Code:** 404 NOT FOUND
  
  * **Content:** 
	```json
		{
			"message": "Action WorkDayLogsController::listt() could not be found, or is not accessible.",
			"url": "/api/work-day-logs/listt.json",
			"code": 404,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Controller\\Controller.php",
			"line": 600
		}
	```
	
**dailyChecker**
----
Returns current work day.

* **URL**

		/api/work-day-logs/dailyChecker.json

* **Method:**

  `GET`
  
*  **URL Params**

	none


* **Success Response:**

  * **Code:** 200
  
  * **Content:** 
	```json
		{
			"message": "OK",
			"data": {
				"work_day_type_id": 25,
				"work_day": "02.09.2019",
				"check_in_time": "08:00",
				"check_out_time": "16:30",
				"year": "2019",
				"month": "9",
				"day": "2",
				"month_name": "September",
				"time_spent": "08:00"
			}
		}
	```
 
* **Error Response:**

  * **Code:** 401 UNAUTHORIZED
  
  * **Content:** 
	```json
		{
			"message": "Unauthorized",
			"url": "/api/work-day-logs/dailyChecker.json",
			"code": 401,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Auth\\BasicAuthenticate.php",
			"line": 96
		}
	```

  OR

  * **Code:** 404 NOT FOUND
  
  * **Content:** 
	```json
		{
			"message": "Action WorkDayLogsController::dailyCheckeer() could not be found, or is not accessible.",
			"url": "/api/work-day-logs/dailyCheckeer.json",
			"code": 404,
			"file": "C:\\Projects\\employee_timesheet\\vendor\\cakephp\\cakephp\\src\\Controller\\Controller.php",
			"line": 600
		}
	```