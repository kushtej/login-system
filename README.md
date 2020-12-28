# Login System

The Perfect Login System with email verification that can be used as an **extention** to my future Django Projects

## Installation and Project Setup :

The following procedure assumes that a virtual enveronment is installed.

**Step 01:** Installation of mysql client :
```bash
$ sudo apt-get install python3-mysqldb libmysqlclient-dev python-dev
```
**Step 02:**  Open MySQL from Terminal :
```
$cd login-system
$ mysql -u root -p

> SOURCE schema.sql;
```
**Step 03:**  Open login/settings.py and add the email credentials :

```python
# EMAIL

EMAIL_BACKEND  =  'django.core.mail.backends.smtp.EmailBackend'
MAILER_EMAIL_BACKEND  =  EMAIL_BACKEND
EMAIL_HOST  =  'smtp.gmail.com'
EMAIL_HOST_PASSWORD  =  'YOUR PASSWORD'  #Your password
EMAIL_HOST_USER  =  'YOUREMAIL@gmail.com'  #your email
EMAIL_PORT  =  465
EMAIL_USE_SSL  =  True
DEFAULT_FROM_EMAIL  =  EMAIL_HOST_USER
```
**Step 04:**  Setting up Gmail accounts for less secure apps :
 Go to [https://www.google.com/settings/security/lesssecureapps](https://www.google.com/settings/security/lesssecureapps) and turn **ON** the option for Allow less secure apps: 


**Step 05:**  Now open your Terminal with previously installed Virtual Environment and type-in :
```
$ pipenv shell
$ pip install -r requirements.txt
$ python manage.py migrate
$ python manage.py makemigrations
$ python manage.py migrate (Optional - Just to be Safe.)
$ python manage.py runserver 

```

**Step 06:**  Now open your Web-Browser and type-in :

```
http://127.0.0.1:8000/
```