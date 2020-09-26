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
            }
        }
    }
}
