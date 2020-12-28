from django import forms
from django.contrib.auth.models import User
from django.contrib.auth import authenticate
from django.contrib import messages

# from accounts import UserProfileInfo

class LoginForm(forms.Form):
    username = forms.CharField()
    password = forms.CharField(widget=forms.PasswordInput)#hides password on input
    
    class Meta():
        model=User
        fields = ['username', 'password']
        # fields = "__all__"
    

    def clean(self,*args,**kwargs):
        username=self.cleaned_data.get("username")
        password=self.cleaned_data.get("password")
        user_qs = User.objects.filter(username=username)
        if user_qs.count() == 0:
            raise forms.ValidationError("username does not exist")
        else:
            if username is not None and password:
                user = authenticate(username=username, password=password)
                # print(user)
                #if not user.is_active:
                if user is None:
                    raise forms.ValidationError("Account is not activated.")
                    # messages.error(self,'Account is not activated.')
                if not user:
                    raise forms.ValidationError("Incorrect password")
                

        return super(LoginForm,self).clean(*args,**kwargs)


class RegistrationForm(forms.ModelForm):

    password = forms.CharField(widget=forms.PasswordInput)#hides password on input
    repassword = forms.CharField(widget=forms.PasswordInput)
   
    class Meta():
        model=User
        fields = ['username','email', 'password', 'repassword']

    def clean(self):
        """
        Verifies that the values entered into the password fields match

        NOTE: Errors here will appear in ``non_field_errors()`` because it applies to more than one field.
        """
        cleaned_data = super(RegistrationForm, self).clean()
        if 'password' in self.cleaned_data and 'repassword' in self.cleaned_data:
            if self.cleaned_data['password'] != self.cleaned_data['repassword']:
                raise forms.ValidationError("Passwords don't match. Please enter both fields again.")
        return self.cleaned_data
    
    def clean_username(self):
        username = self.cleaned_data['username']
        if User.objects.exclude(pk=self.instance.pk).filter(username=username).exists():
            raise forms.ValidationError(u'Username "%s" is already in use.' % username)
        return username

    def save(self, commit=True):
        users = super(RegistrationForm, self).save(commit=False)
        users.set_password(self.cleaned_data['password'])

        if commit:
            users.save()
        return users