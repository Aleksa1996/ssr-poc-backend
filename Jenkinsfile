pipeline {
    agent any
    parameters {
        string(name: 'dockerImageTarget', defaultValue: 'test', description: 'Image stage build target')
        string(name: 'dockerImageFile', defaultValue: 'Dockerfile', description: 'Path to Dockerfile')
    }
    environment {
        AWS_DEFAULT_REGION = 'us-west-2'
        AWS_ACCOUNT_ID = credentials('AWS_ACCOUNT_ID')
        AWS_ACCESS_KEY_ID = credentials('AWS_ACCESS_KEY_ID')
        AWS_SECRET_ACCESS_KEY = credentials('AWS_SECRET_ACCESS_KEY')
    }
    stages {
        stage('Init') {
            steps {
                sh "docker image build -t ${dockerImageTarget}-app-image:${env.BUILD_ID} --target ${dockerImageTarget} -f ${dockerImageFile} ."
                sh "docker container run -d --name ${dockerImageTarget}-app-image-${env.BUILD_ID} ${dockerImageTarget}-app-image:${env.BUILD_ID}"
            }
        }
        stage('Test') {
            steps {
                sh "docker container exec ${dockerImageTarget}-app-image-${env.BUILD_ID} bash -c 'phpstan analyse /var/www/html/src'"
                sh "docker container rm -f ${dockerImageTarget}-app-image-${env.BUILD_ID}"
            }
        }
         stage('Publish') {
            steps {
                sh "aws ecr get-login-password --region ${AWS_DEFAULT_REGION} | docker login --username AWS --password-stdin ${AWS_ACCOUNT_ID}.dkr.ecr.${AWS_DEFAULT_REGION}.amazonaws.com"
            }
        }
    }
}
