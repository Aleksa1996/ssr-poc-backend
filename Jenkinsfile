pipeline {
    agent any
    parameters {
        string(name: 'dockerImageTarget', defaultValue: 'test', description: 'Image stage build target')
        string(name: 'dockerImageFile', defaultValue: 'Dockerfile', description: 'Path to Dockerfile')
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
                sh "docker container exec -it ${dockerImageTarget}-app-image-${env.BUILD_ID} phpstan analyse /var/www/html/src"
            }
        }
    }
}
