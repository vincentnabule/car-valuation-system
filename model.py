#importing required packages
import pandas as pd
import numpy as np
import datetime as dt
from sklearn.model_selection import train_test_split
import pickle
import sys

#Read the data
data = pd.read_csv("train-data.csv")

# Change the Year column to the years of usage
data['Year'] = dt.date.today().year - data['Year']

# Select the first word of the Power column
data['Power'] =data['Power'].apply(lambda x: str(x).split(' ')[0])
data['Power'] = [np.nan if x=='null' else x for x in data['Power']]
data['Power'] = [np.nan if x=='nan' else x for x in data['Power']]

# Select the first word of the Engine column
data['Engine'] =data['Engine'].apply(lambda x: str(x).split(' ')[0])
data['Engine'] = [np.nan if x=='null' else x for x in data['Engine']]
data['Engine'] = [np.nan if x=='nan' else x for x in data['Engine']]

# Replace missing values with median value of the column
power_median = data['Power'].median() 
data['Power'] = data['Power'].fillna(power_median)

seat_median = data['Seats'].median()
data['Seats'] = data['Seats'].fillna(seat_median)

# Drop the remaining rows with missing value
data.dropna(axis=0, inplace=True)

#Separating car make from car model
data['Car_Make'] = data['Name'].apply(lambda x: x.split(' ')[0].upper())
data['Car_Model'] = data['Name'].apply(lambda x: x.split(' ')[1].upper())

#Selecting Required attributes.
data = data[['Car_Make','Car_Model','Year','Kilometers_Driven','Fuel_Type','Transmission','Engine','Power','Seats','Price']]

# Hot encoder ,
data = pd.get_dummies(data, columns=['Car_Make','Car_Model','Fuel_Type','Transmission'])

# Independent variable
X = data.drop(['Price'], axis=1)
# Dependent variable
y = data['Price']

# Split the data into train and test
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2)

# Loading the model
model = open("Car_Value.pickle","rb")
car_value = pickle.load(model)

# Car prediction function that implements the model
def predict_price(car_details):
    car_make = car_details[0]
    car_model = car_details[1]
    year = int(car_details[2])
    km = int(car_details[3])
    fuel = car_details[4]
    transmission = car_details[5]
    engine = int(car_details[6])
    power = int(car_details[7])
    seats = int(car_details[8])
    year = dt.date.today().year - year

    carMake = np.where(X.columns=='Car_Make_'+car_make.upper())[0][0]
    carModel = np.where(X.columns=='Car_Model_'+car_model.upper())[0][0]
    fuel_index = np.where(X.columns=='Fuel_Type_'+fuel)[0][0]
    transmission_index = np.where(X.columns=='Transmission_'+transmission)[0][0]
    x = np.zeros(len(X.columns))
    x[0] = year
    x[1] = km
    x[2] = engine
    x[3] = power
    x[4] = seats
    if carMake >= 0:
        x[carMake] = 1
    if carModel >= 0:
        x[carModel] = 1
    if fuel_index >= 0:
        x[fuel_index] = 1
    if transmission_index >= 0:
        x[transmission_index] = 1
    value =  round(car_value.predict([x])[0], 2)
    
    return f'{(value*10000*year)}'

if __name__ == '__main__':
   pdo = sys.argv[1:]
   print(predict_price(pdo))