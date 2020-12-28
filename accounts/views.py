from django.shortcuts import render, redirect

from accounts import forms

from django.http import HttpResponseRedirect,HttpResponse

from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import login_required
from django.contrib.auth.models import User
from django.contrib import messages
from django.contrib.auth import update_session_auth_hash, get_user_model
from django.contrib.auth.tokens import default_token_generator
from django.contrib.sites.shortcuts import get_current_site
from django.contrib.auth.forms import PasswordChangeForm   

from django.urls import reverse

from django.core.mail import EmailMessage, EmailMultiAlternatives

from django.template.loader import render_to_string

from django.utils.encoding import force_bytes
from django.utils.http import urlsafe_base64_encode, urlsafe_base64_decode
from django.utils.safestring import mark_safe


# Create your views here.


# Signup View
def signup_view(request):
    if request.method == "GET":
        username = request.GET.get('username')
        # print(username)
        if username is not None:
            if User.objects.filter(username__iexact=username):
                return HttpResponse(False)
            else:
                return HttpResponse(True)

    if request.method == 'POST':
        
        form = forms.RegistrationForm(data=request.POST)
        if form.is_valid():
            users = form.save(commit=False)
            users.is_active = False
            users.save()
            current_site = get_current_site(request)
            mail_subject = 'Activate your account.'
            message = render_to_string('accounts/acc_activate_email.html', {
                'user': users,
                'domain': current_site.domain,
                'uid': urlsafe_base64_encode(force_bytes(users.pk)),
                'token': default_token_generator.make_token(users),
            })
            to_email = form.cleaned_data.get('email')
            msg = EmailMultiAlternatives(mail_subject, message, 'ihave10.0gpa@gmail.com', to=[to_email])
            msg.attach_alternative(message, "text/html")
            msg.send()
            return HttpResponse('Please confirm your email address to complete the registration')
    else:
        form = forms.RegistrationForm()
    return render(request,'accounts/signup.html', {'form': form,})




# Email Activation Function
def activate(request, uidb64, token):

    UserModel = get_user_model()
    try:
        uid = urlsafe_base64_decode(uidb64).decode()
        user = UserModel._default_manager.get(pk=uid)
    except(TypeError, ValueError, OverflowError, User.DoesNotExist):
        user = None
    
    if user is not None and default_token_generator.check_token(user, token):
        user.is_active = True
        user.save()
        messages.success(request, 'Email Activation Successful')
        return redirect('accounts:login_view')
    else:
        return HttpResponse('Activation link is invalid!')


# Login View
def login_view(request):
    if request.method == 'POST':
        form = forms.LoginForm(request.POST)
        if form.is_valid():
            user=authenticate(username=request.POST['username'],password=request.POST['password'])
            if user is not None:
                if user.is_active:
                    login(request, user)
                    return redirect("accounts:homepage_view")
            else:
                return HttpResponse("You not are active but logged in!...")
    else:
        form=forms.LoginForm()
    return render(request,'accounts/login.html', {'form': form,})    



# HomePage View
@login_required(login_url='/')
def homepage_view(request):
    return render(request,'accounts/homepage.html')



@login_required(login_url='/')
def logout_view(request):
    logout(request)      
    return HttpResponseRedirect('/')


@login_required(login_url='/')
def change_password_view(request):
    if request.method == 'POST':
        form = PasswordChangeForm(request.user, request.POST)
        if form.is_valid():
            user = form.save()
            update_session_auth_hash(request, user)  # Important!
            messages.success(request, 'Your password was successfully updated!')
            return HttpResponse('change_password')
        else:
            messages.error(request, 'Please correct the error below.')
    else:
        form = PasswordChangeForm(request.user)
    return render(request, 'accounts/change_password.html', {
        'form': form
    })


def profile_view(request,username=None):
    try:
        user = User.objects.get(username=username)
        if(user is not None):
            return render(request, "accounts/profile.html", {"user": user,})
        else:
            return render("User not found")
    except User.DoesNotExist:
        return HttpResponse("User not found")
