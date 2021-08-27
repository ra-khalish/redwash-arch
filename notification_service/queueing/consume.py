import time, pika, json
from emailing.mail import send_email

class NotifConsumer(object):
    # Class to consume message to RMQ server using pika
    def __init__(self, channel, exchange_name, routing_key, queue_name, logger):
        self._channel = channel
        self._exchange_name = exchange_name
        self._routing_key = routing_key
        self._queue_name = queue_name
        self._logger = logger

    def declare_exchange(self):
        # Declares the exchange to consume message from, 
        # with type of 'direct'
        self._logger.info("Exchange declared with direct type")
        self._channel.exchange_declare(
            exchange=self._exchange_name,
            exchange_type='direct',
            passive=False, 
            durable=True)
        print (" [*] Exchange declared...")

    def declare_queue(self):
        # Get the name of the queue, 
        # which is automatically created by the RMQ server
        self._logger.info("Queue declared with durable features")
        result = self._channel.queue_declare(
            self._queue_name, durable=True)
        self._queue_name = result.method.queue
        print (" [*] Queue declared...")

    def make_binding(self):
        # Bind the queue to the exchange with routing key
        self._logger.info("Queue binding to Exchange")
        self._channel.queue_bind(exchange=self._exchange_name,
                                routing_key=self._routing_key,
                                queue=self._queue_name)
        print(" [*] Made binding between exchange: %s and queue: %s" %(self._exchange_name, self._queue_name))

    def on_message(self, channel, method, properties, body):
        """
        Called when a message is received. Does not need to send an acknowledgement.
        :param channel: channel passed through from server on callback
        :param method: message details passed through from server on callback
        :param properties: message properties passed through from server on callback
        :param body: message body passed through from server on callback
        """
        
        self._logger.info("channel: %s" %channel)
        self._logger.info("method: %s" %method)
        self._logger.info("properties: %s" %properties)
        print(" [x] Feed Received - %s \n" %str(body))

        msg = json.loads(body)
        self._logger.info("Sending notification email")
        send_email(msg)

        time.sleep(2)
        print( " [*] Waiting for message. To exit press CTRL+C")

    def consume_message(self):
        # Consume all message that are send to the specific Direct Exchange
        print( " [*] Waiting for message. To exit press CTRL+C")
        self._logger.info('Start consuming queue')
        self._channel.basic_consume(self._queue_name, self.on_message,
                                    auto_ack=True)
        self._channel.start_consuming()

    def run(self):
        self.declare_exchange()
        self.declare_queue()
        self.make_binding()
        self.consume_message()

    # print(configuration.get_property('SENDGRID_SENDER'))
    # print(os.environ['SENDGRID_SENDER'])
    # queueName = configuration.get_property('QUEUE_NAME')

    # sleepTime = 10
    # print(' [*] Sleeping for ', sleepTime, ' seconds.')
    # time.sleep(30)

    # print(' [*] Connecting to server ...')
    # connection = pika.BlockingConnection(
    #     pika.URLParameters(configuration.get_property['BROKER_URL_DEVELOPMENT'])
    # )
    # channel = connection.channel()
    # channel.queue_declare(queue=configuration.get_property('QUEUE_NAME'), durable=True)
        

    # def callback(ch, method, properties, body):
    #     print(" [x] Received %s" % body)
    #     cmd = body.decode()

    #     if cmd == 'hey':
    #         print("hey there")
    #     elif cmd == 'hello':
    #         print("well hello there")
    #     else:
    #         print("sorry i did not understand ", body)

    #     print(" [x] Done")

    #     ch.basic_ack(delivery_tag=method.delivery_tag)

    # channel.basic_qos(prefetch_count=1)
    # channel.basic_consume(queue='myqueue', on_message_callback=callback,)
    # print('Started Consuming')
    # channel.start_consuming()
    
    # def __init__(self, channel, consume_queue_name, routing_key, logger):
    #     self.logger = logger
    #     self.channel = channel
    #     self.consume_queue_name = consume_queue_name

    #     self.properties = pika.BasicProperties(
    #         delivery_mode=2
    #     )

    #     self.logger.debug("Email consumer starting")
    #     self.channel.queue_declare(queue=consume_queue_name, durable=True)

    #     self.logger.debug("Queue declared with name: %s" %consume_queue_name)
    #     self.channel.basic_consume(self.callback, queue=consume_queue_name,no_ack=False)

    #     self.logger.debug("Start consuming queue")
    #     self.channel.start_consuming()

    # def callback(self, ch: pika.adapters.blocking_connection.BlockingChannel, method, properties, body):
    #     self.logger.info("Received message")

    #     if not self.proc