pipeline {
    agent any
    parameters {
        string(name: 'DOCKER_IMAGE_TARGET', defaultValue: 'test', description: 'Image stage build target')
        string(name: 'DOCKER_IMAGE_FILE', defaultValue: 'Dockerfile', description: 'Path to Dockerfile')
    }
    environment {
        DOCKER_IMAGE_NAME = 'backend-app'
        AWS_DEFAULT_REGION = 'us-west-2'
        AWS_ACCOUNT_ID = credentials('AWS_ACCOUNT_ID')
        AWS_ACCESS_KEY_ID = credentials('AWS_ACCESS_KEY_ID')
        AWS_SECRET_ACCESS_KEY = credentials('AWS_SECRET_ACCESS_KEY')
    }
    stages {
        stage('Init') {
            steps {
                sh "docker image build -t ${DOCKER_IMAGE_TARGET}-${DOCKER_IMAGE_NAME}:${env.BUILD_ID} --target ${DOCKER_IMAGE_TARGET} -f ${DOCKER_IMAGE_FILE} ."
                sh "docker container run -d --name ${DOCKER_IMAGE_TARGET}-${DOCKER_IMAGE_NAME}-${env.BUILD_ID} ${DOCKER_IMAGE_TARGET}-${DOCKER_IMAGE_NAME}:${env.BUILD_ID}"
            }
        }
        stage('Test') {
            steps {
                sh "docker container exec ${DOCKER_IMAGE_TARGET}-${DOCKER_IMAGE_NAME}-${env.BUILD_ID} bash -c 'phpstan analyse /var/www/html/src'"
                sh "docker container rm -f ${DOCKER_IMAGE_TARGET}-${DOCKER_IMAGE_NAME}-${env.BUILD_ID}"
            }
        }
         stage('Publish') {
            steps {
                sh "aws ecr get-login-password --region ${AWS_DEFAULT_REGION} | docker login --username AWS --password-stdin ${AWS_ACCOUNT_ID}.dkr.ecr.${AWS_DEFAULT_REGION}.amazonaws.com"
                sh "docker tag ${DOCKER_IMAGE_TARGET}-${DOCKER_IMAGE_NAME}:${env.BUILD_ID} ${AWS_ACCOUNT_ID}.dkr.ecr.${AWS_DEFAULT_REGION}.amazonaws.com/aleksajo/${DOCKER_IMAGE_NAME}:${env.BUILD_ID}"
                sh "docker push ${AWS_ACCOUNT_ID}.dkr.ecr.${AWS_DEFAULT_REGION}.amazonaws.com/aleksajo/${DOCKER_IMAGE_NAME}:${env.BUILD_ID}"
            }
        }
    }
}
