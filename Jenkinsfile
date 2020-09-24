pipeline {
    agent any
    parameters {
        string(name: 'dockerImageTarget', defaultValue: 'test', description: 'Image stage build target')
        string(name: 'dockerImageFile', defaultValue: 'Dockerfile', description: 'Path to Dockerfile')
    }
    stages {
        stage('Init') {
            script {
                dockerGv = load 'docker.groovy'
            }
        }
        stage('Build') {
            script {
                dockerImage = dockerGv.buildImage(dockerImageTarget, dockerImageFile)
            }
            dockerImage.inside {
                sh 'ls'
            }
        }
        stage('Test') {
            agent {
                docker {
                    image 'jakzal/phpqa:latest'
                }
            }
            steps {
                sh 'phpstan analyse src'
            }
        }
    }
}