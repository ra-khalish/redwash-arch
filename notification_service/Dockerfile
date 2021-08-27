FROM python:3.6.9-alpine

LABEL maintainer="Rafi Khalish <rafi.khalish30@gmail.com>"

ENV PYTHONUNBUFFERED 1

# set working directory
WORKDIR /app
# copy requirements from local to container
COPY requirements.txt .
# install depedencies
RUN pip install -r requirements.txt
# copy our project from local to container
COPY . .

# command to run on container start
CMD ["python", "run.py"]
