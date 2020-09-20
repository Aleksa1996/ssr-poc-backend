pipeline {
    agent {
        docker {
            image 'jakzal/phpqa:latest'
        }
    }
    stages {
        stage('Build') {
            steps {
                sh 'composer install'
            }
        }
        stage('Test') {
            steps {
                sh 'phpstan analyse src'
            }
        }
    }
}