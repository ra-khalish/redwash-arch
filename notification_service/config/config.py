from dotenv import load_dotenv
import os

load_dotenv()

# dict config 
conf = {
    # key : value
    'EXCHANGE_NAME': os.getenv("EXCHANGE_NAME"),
    'QUEUE_NAME' : os.getenv("QUEUE_NAME"),
    'ROUTING_KEY' : os.getenv("ROUTING_KEY"),
    'BROKER_URL' : os.getenv("BROKER_URL"),
    'SENDGRID_API_KEY' : os.getenv("SENDGRID_API_KEY"),
    'SENDGRID_SENDER' : os.getenv("SENDGRID_SENDER") ,
}

# class config with object 
class Config(object):
    def __init__(self):
        self._config = conf # set it to conf

    def get_property(self, property_name):
        # we don't want keyerror
        if property_name not in self._config.keys():
            return None  # just return None if not found
        return self._config[property_name]
