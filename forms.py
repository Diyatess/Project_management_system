from django import forms
from .models import client

class DateInput(forms.DateInput):
    input_type = 'date'
# client registration 
class ClientForm(forms.ModelForm): 
    class Meta:
        model = client
        fields ='__all__'

        widgets ={
            'exp_end_date' : DateInput(),
            'paswrd': forms.PasswordInput(),
        }

        labels ={
            'cname': "UserName",
            'pgm_lang': "Programing Language Preffered",
            'frontend' : "Front end preffered",
            'backend' : "Back end preffered",
            'contact' : "Contact Number",
            'email' : "Email Id",
            'exp_end_date' : "Expected Date of Completion",
            'description' : "Description",
            'paswrd' : "Password",
        }

#login page
class LoginForm(forms.Form):
    username = forms.CharField(max_length=65)
    password = forms.CharField(max_length=65, widget=forms.PasswordInput)