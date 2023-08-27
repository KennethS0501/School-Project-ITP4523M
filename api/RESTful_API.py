'''
How to create a simple REST API with Python and Flask in 5 minutes
https://medium.com/duomly-blockchain-online-courses/how-to-create-a-simple-rest-api-with-python-and-flask-in-5-minutes-94bb88f74a23
https://pythonbasics.org/flask-tutorial-routes/
run : pip install flask
Testing :
URL : http://127.0.0.1:8080/api/apple/30
output on browser :
{
  "para1": "apple",
  "para2": "30"
}
'''

from flask import Flask

app = Flask(__name__)

@app.route("/api/RESTful_API.py/<para1>")
def process(para1=None, para2=None):
    # processing of request data goes here ...
    response_data = {"para1": para1}
    return response_data

if __name__ == "__main__":
    app.run(debug=True,
            host='127.0.0.1',
            port=8080)
