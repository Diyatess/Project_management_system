from django.shortcuts import render,redirect
from django.http import HttpResponse
from django.contrib import messages
from .models import depatments
from .forms import ClientForm,LoginForm
from django.contrib.auth import authenticate, login,logout


# Create your views here.
def index(request):
    return render(request,'index.html')

#login page
def ind(request):
    if request.method == 'GET':
        form = LoginForm()
        return render(request, 'ind.html', {'form': form})
    elif request.method == 'POST':
        form = LoginForm(request.POST)
        
        if form.is_valid():
            username = form.cleaned_data['username']
            password = form.cleaned_data['password']
            user = authenticate(request,username=username,password=password)
            if user:
                login(request, user)
                messages.success(request,f'Hi {username.title()}, welcome back!')
                return render(request,'client.html')
        messages.error(request,f'Invalid username or password')
        return render(request,'ind.html',{'form': form})
    return render(request,'ind.html')

def signup(request):#client registration
    if request.method =="POST":
        form = ClientForm(request.POST)
        if form.is_valid():
            form.save()
            return render(request,'client.html')
    else:
        form = ClientForm()
    dict_forms={
        'form': form
    }
    return render(request,'signup.html',dict_forms)

def teamlead(request):
    return render(request,'teamlead.html')

def teammem(request):
    return HttpResponse("Team member")

#def client(request):
    
    return render(request,'signup.html')

def department(request):
    dict_dept={
        'dept': depatments.objects.all()
    }
    return render(request,'department.html',dict_dept)

def logout_view(request):
    logout(request)
    return render(request,'index.html')