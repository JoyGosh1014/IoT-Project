#!C:/Users/User/AppData/Local/Programs/Python/Python37/python.exe

# Simple Linear Regression

# Importing the libraries

import numpy as np
import pandas as pd
from sklearn.linear_model import LinearRegression

# Importing the dataset
dataset = pd.read_csv('test2.csv')
x = dataset.iloc[:,:-1].values
y = dataset.iloc[:,-1].values

# # from sklearn.preprocessing import LabelEncoder, OneHotEncoder
# # labelencoder = LabelEncoder()
# # x = labelencoder.fit_transform(x)
# # onehotencoder = OneHotEncoder(categorical_features = [0,1,2])
# # x = onehotencoder.fit_transform(x).toarray()

# # Avoiding the Dummy Variable Trap
# #X = X[:, 1:]


model = LinearRegression().fit(x, y)



x_new = [[6, 0, 0]]

# # from sklearn.preprocessing import LabelEncoder, OneHotEncoder
# # labelencoder = LabelEncoder()
# # x_new = labelencoder.fit_transform(x_new)
# # onehotencoder = OneHotEncoder(categorical_features = [0,1,2])
# # x_new = onehotencoder.fit_transform(x_new).toarray()

y_new = model.predict(x_new)

#print(y_new)

# import cgi, cgitb

# form = cgi.FieldStorage();



#name = "abir";
#b = 2;
#print ("Content-type:text/html\n")
#print ("<h2> %s</h2>" %b)

print ("Content-type:text/html\n")
print ("<h2> %s</h2>" %y_new)