from django.urls import path
from django.conf.urls import url
from accounts import views
from django.shortcuts import redirect



app_name = 'accounts'

urlpatterns = [
    path('', views.login_view,name='login_view'),
    path('signup/', views.signup_view,name='signup_view'),
    path('homepage/', views.homepage_view,name='homepage_view'),
    path('logout/',views.logout_view,name='logout'),
    path('changepassword/',views.change_password_view,name='changepassword'),
    path('activate/<uidb64>/<token>/',views.activate, name='activate'),
    path('<username>/', views.profile_view, name="profile"),

    # path('', lambda req: redirect('homepage/')),
]
