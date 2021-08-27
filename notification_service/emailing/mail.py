from sendgrid import SendGridAPIClient
from sendgrid.helpers.mail import Mail, From
from jinja2 import Template, Environment, FileSystemLoader
from config.config import Config

# sending email
def send_email(msg):
    # load config file
    configuration = Config()

    # set message to variable
    subject = msg['subject']
    to_email = msg['to_email']
    html_content = msg['html_content']
    data_content = msg['data_content']
    # {
    #     'brand': 'R-Wash',
    #     'customer_name': msg['name'],
    #     'text': 'Come on, immediately bring Your vehicle here',
    #     'code_booking': msg['code_booking'],
    #     'motor_type': msg['motor_type'],
    #     'total': msg['tot_cost'],
    #     'status': msg['status'],
    #     'order_created': msg['ctime'],
    #     'order_timeupdate': msg['etime'],
    #     'action': 'https://redwash.000webhostapp.com/user/queue',
    # }

    # set Mail class to message
    message = Mail(
        from_email=From(
            configuration.get_property('SENDGRID_SENDER'),
             "R-Wash"
             ),
        to_emails=to_email,
        subject=subject,
        html_content=body_email(data_content, html_content)
    )
    try:
        # set api key to sendgrid_client
        sendgrid_client = SendGridAPIClient(
            configuration.get_property('SENDGRID_API_KEY'))
        # send message
        print('Sending email')
        response = sendgrid_client.send(message)
        # print response
        print('Status: ',response.status_code)
        print(response.body)
        print(response.headers)
    except Exception as e:
        print(e.message)

    return response.status_code

def body_email(data_content, html_content):
    content = data_content # set data_content

    # define FileSystemLoader to retrieved 
    # template from the templates directory
    env = Environment(loader=FileSystemLoader("templates"))

    # get template file
    template = env.get_template('%s.html' %html_content)

    # render data content to template
    output = template.render(body=content)
    return output