import logging, time
# get datestamp
timestr = time.strftime("%Y-%m-%d")

def setup_logging():
    # # Define file handler and set formatter
    # file_handler = logging.FileHandler('logs/app_'+timestr+'.log')
    # formatter = logging.Formatter('%(asctime)s :: %(levelname)s :: Module %(module)s :: Line No %(lineno)s :: %(message)s')
    # file_handler.setFormatter(formatter)

    # # Add file handler to logger
    # logger.addHandler(file_handler)

    logging.basicConfig(
        # set level logs to INFO 
        level=logging.INFO,

        # modify file name with datestamp
        filename='logs/app_'+timestr+'.log', 

        # set the log format
        format='%(asctime)s :: %(levelname)s :: Module %(module)s :: Line No %(lineno)s :: %(message)s')
