from flask import Flask
from flask.ext.pymongo import PyMongo

app = Flask(__name__)

app.config['MONGO_DBNAME'] = 'Cluster0'
app.config['MONGO_URI'] = 'mongodb://guilinden:iNTERNACIONAL1/@cluster0-shard-00-00-psck3.mongodb.net:27017,cluster0-shard-00-01-psck3.mongodb.net:27017,cluster0-shard-00-02-psck3.mongodb.net:27017/test?ssl=true&replicaSet=Cluster0-shard-0&authSource=admin'

mongo = PyMongo(app)

@app.route('/add')
def add():
	user = mongo.db.users
	user.insert({'name' : 'Guilherme'})
	return 'Added user'

if __name__ == '__main__':
	app.run(debug=True)

