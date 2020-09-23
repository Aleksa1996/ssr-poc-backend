pipeline {
    environment {
        APP_TEST_ENV_VARIABLE = '5555'
    }

    agent any

    stages {
        stage('Build') {
            def dockerfile = 'Dockerfile'
            def image = docker.build("my-image:${env.BUILD_ID}", "--target test -f ${dockerfile} .")
            image.inside {
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