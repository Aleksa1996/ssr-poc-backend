pipeline {
    agent none
    stages {
        stage('Build') {
            agent {
                dockerfile true
            }
            steps {
                sh 'ls'
            }

        }
        stage('Test') {
            environment {
                APP_TEST_ENV_VARIABLE = '5555'
            }

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