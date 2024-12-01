#methode 1
import sqlite3
import os
#tools

def tri_selection(tab):
   for i in range(len(tab)):
      # Trouver le min
       min = i
       for j in range(i+1, len(tab)):
           if tab[min][1] > tab[j][1]:
               min = j
       tmp = tab[i]
       tab[i] = tab[min]
       tab[min] = tmp
   return tab

def sql_reader():
	table = input("Quelle table voulez vous lire ? press ENTER to stop. ")
	if table:
		connection = sqlite3.connect("meteo_villes_1.db")
		crsr = connection.cursor()

		sql_select=f"""SELECT * FROM {table}"""
		i = 0
		for row in crsr.execute(sql_select):
			print(i,row)
			i += 1
		connection.commit()
		connection.close()

def k_to_c(temp: int) -> int:
	"""convert an int from kelvin to celsius and return an int"""
	if not (type(temp) == int or type(temp) == float):
		raise TypeError('you must input one integer')
	elif temp < 0:
		raise ValueError('argument cannot be negative')

	return round(temp-273.15, 1)

def fill_table(data: str)-> None:
	"""put data in database"""

	data = data.split("@")

	connection = sqlite3.connect("meteo_villes_1.db")
	crsr = connection.cursor()

	sql_insert = f"""INSERT INTO meteo (_timestamp, _date, heureUCT, temperature, t_ressentie, pression,
	humidite, vit_vent, dir_vent, description, ville)
	VALUES({int(data[0])}, "{data[1]}", {int(data[2])}, {float(data[3])}, {float(data[4])}, {int(data[5])}, {int(data[6])},  {float(data[7])}, {int(data[8])}, "{data[9]}", "{data[10]}");"""

	crsr.execute(sql_insert)
	connection.commit()
	connection.close()


def meteo_120h(place: str,latitude: str, longitude: str)-> None:
	"""main function of the programm :
	use an API to extract data and send required data to the fill_table function, which
	fill a database with the data."""

	import datetime
	import requests
	import time

	connection = sqlite3.connect("meteo_villes_1.db")
	crsr = connection.cursor()

	sql_insert = f"""INSERT INTO villes (nom, lat, lon)
	VALUES("{place}", {latitude}, {longitude});"""

	crsr.execute(sql_insert)
	connection.commit()
	connection.close()

	h=0

	date = str(datetime.datetime.now())[0:10]
	dat=datetime.datetime.now()

	temps=time.time()-dat.hour*3600-dat.minute*60-dat.second
	temps=temps-428400
	latest = round(temps)

	for j in range(5):
		appid = "cc246045c1ef059df9d33bb5631ff9ee"
		appicall = "http://api.openweathermap.org/data/2.5/onecall/timemachine?"

		url = appicall + "lat=" + latitude + "&lon=" + longitude + "&dt="+ str(int(temps)) +"&appid=" + appid + "&lang=fr"
		temps += 86400
		meteo = requests.get(url).json()

		for i in range(24):
			temperature = k_to_c(meteo['hourly'][i]['temp'])

			sky = meteo['hourly'][i]['weather'][0]['description']

			temps_a = (datetime.datetime.now() - datetime.timedelta(j)).strftime('%Y-%m-%d')

			temperature_ress= k_to_c(meteo['hourly'][i]['feels_like'])

			pressure = meteo['hourly'][i]['pressure']

			humidity = meteo['hourly'][i]['humidity']

			wind_speed= meteo['hourly'][i]['wind_speed']

			wind_deg = meteo['hourly'][i]['wind_deg']

			data = f"{latest}@{temps_a}@{h}@{temperature}@{temperature_ress}@{pressure}@{humidity}@{wind_speed}@{wind_deg}@{sky}@{place}"
			fill_table(data)

			latest += 3600
			h+=1
		h=0

#create the database
from os.path import exists
print("Cheking if the file exist...")
if exists("meteo_villes_1.db"):
	if input("la base de donnée sql existe déjà, la garder ? press ENTER to keep it"):
		os.remove("meteo_villes_1.db")

		print("creating the files...")
		connection = sqlite3.connect("meteo_villes_1.db")

		crsr = connection.cursor()

		sql_def = """CREATE TABLE villes (
		nom TEXT PRIMARY KEY,
		lat REAL,
		lon REAL);"""

		sql_def2="""CREATE TABLE meteo (
		ville TEXT,
		_timestamp INTEGER,
		_date TEXT,
		heureUCT INTEGER,
		temperature REAL,
		t_ressentie REAL,
		pression INTEGER,
		humidite INTEGER,
		vit_vent REAL,
		dir_vent INTEGER,
		description TEXT,
		FOREIGN KEY (ville) REFERENCES villes(nom));"""

		crsr.execute(sql_def)
		connection.commit()
		crsr.execute(sql_def2)
		connection.commit()

		connection.close()

		print("files created.")
		print("loading data...")

		meteo_120h("Brest","39","116")
		meteo_120h("Lille","50","3")
		meteo_120h("Toulouse","43","1")
		meteo_120h("Marseille","43","5")
		print("database successfully created!")
else:
	print("creating the files...")
	connection = sqlite3.connect("meteo_villes_1.db")
	crsr = connection.cursor()

	sql_def = """CREATE TABLE villes (
	nom TEXT PRIMARY KEY,
	lat REAL,
	lon REAL);"""

	sql_def2="""CREATE TABLE meteo (
	ville TEXT,
	_timestamp INTEGER,
	_date TEXT,
	heureUCT INTEGER,
	temperature REAL,
	t_ressentie REAL,
	pression INTEGER,
	humidite INTEGER,
	vit_vent REAL,
	dir_vent INTEGER,
	description TEXT,
	FOREIGN KEY (ville) REFERENCES villes(nom));"""

	crsr.execute(sql_def)
	connection.commit()
	crsr.execute(sql_def2)
	connection.commit()

	connection.close()

	print("files created.")
	print("loading data...")

	meteo_120h("Brest","39","116")
	meteo_120h("Lille","50","3")
	meteo_120h("Toulouse","43","1")
	meteo_120h("Marseille","43","5")
	print("database successfully created!")
sql_reader()
#---
connection = sqlite3.connect("meteo_villes_1.db")
crsr = connection.cursor()

sql_select=f"""SELECT ville, avg(temperature), min(temperature), max(temperature), _date FROM meteo GROUP BY ville, _date"""

print("nom de la ville, moyenne, min, max, date")
for row in crsr.execute(sql_select):
	print(row)
connection.commit()
connection.close()

#---
connection = sqlite3.connect("meteo_villes_1.db")
crsr = connection.cursor()

sql_select=f"""SELECT ville, avg(temperature) FROM meteo GROUP BY ville"""

moyenne = []
for row in crsr.execute(sql_select):
	moyenne.append(row)
connection.commit()
connection.close()

moyenne = tri_selection(moyenne)
print("moyenne des temperatures des villes sur les 5 jours :\n"+str(moyenne))
