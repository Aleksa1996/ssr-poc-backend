pipeline {
    environment {
        APP_TEST_ENV_VARIABLE = '5555'
        DOCKERFILE = 'Dockerfile'
        IMAGE = ''
    }

    agent any

    stages {
        stage('Build') {
            IMAGE = docker.build("my-image:${env.BUILD_ID}", "--target test -f ${DOCKERFILE} .")
            IMAGE.inside {
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
                sh 'curl -X GET php:1215'
            }
        }
    }
}