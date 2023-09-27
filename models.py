from django.db import models
from datetime import date
from django.core.validators import RegexValidator

# Create your models here.
class depatments(models.Model):
    dname = models.CharField(max_length=100)
    description = models.TextField()
    def __str__(self) :
        return self.dname

class employee(models.Model):
    fname = models.CharField(max_length=100)
    lname = models.CharField(max_length=100)
    address = models.TextField()
    phone = models.IntegerField(unique=True)
    dob = models.DateField()
    doj = models.DateField( default=date.today)
    email = models.EmailField()
    password = models.CharField(max_length=20)

class role(models.Model):
    Rname = models.CharField(max_length=100)
    rdescrip= models.TextField()
 
class client(models.Model):
    cname= models.CharField(max_length=100)
    pgm_lang = models.CharField(max_length=100)
    frontend = models.CharField(max_length=100)
    backend = models.CharField(max_length=100)
    contact = models.CharField(max_length=100,unique=True,validators=[RegexValidator(regex='^.{10}$',message='length has to be 10', code='nomatch')])
    email = models.EmailField()
    exp_end_date = models.DateField()
    description = models.CharField(max_length=100)
    paswrd = models.CharField(max_length=50, default='default_value_here')