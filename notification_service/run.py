import time, pika, os, logging
from config.config import Config
from queueing.consume import NotifConsumer
from helper.utils import setup_logging

# Store config class to configuration
configuration = Config()

# Define connect function to connect broker server
def connect(retry_count=5):
    if retry_count == 0:
        os.sys.exit(-1) # exit
    try:
        # Make connection to RMQ Server with BROKER_URL from config
        print(' [*] Connecting to server ...')
        conn = pika.BlockingConnection(
            pika.URLParameters(configuration.get_property('BROKER_URL'))
        )
        return conn
    except Exception as err:
        print("Trying to reconnect: %s" %type(err))
        print(err)
        time.sleep(5)
        return connect(retry_count-1)
    

if __name__ == "__main__":
    setup_logging() # run setup logging

    connection = connect() # set it to connection

    # Open channel
    channel = connection.channel()
    
    # Call NotifConsumer class with object
    consumer = NotifConsumer(channel,
                configuration.get_property('EXCHANGE_NAME'),
                configuration.get_property('ROUTING_KEY'),
                configuration.get_property('QUEUE_NAME'),
                logging.getLogger('NotifConsumer')
                )
    # then execute run function
    consumer.run()

