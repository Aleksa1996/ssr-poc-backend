pipeline {
    agent any
    parameters {
        string(name: 'dockerImageTarget', defaultValue: 'test', description: 'Image stage build target')
        string(name: 'dockerImageFile', defaultValue: 'Dockerfile', description: 'Path to Dockerfile')
    }
    stages {
        stage('Init') {
            steps {
                script {
                    dockerGv = load 'docker.groovy'
                    dockerGv.buildImage(dockerImageTarget, dockerImageFile)
                }
            }
        }
    }
}
