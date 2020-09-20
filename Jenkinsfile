pipeline {
    agent {
        docker { image 'jakzal/phpqa:latest' }
    }
    stages {
        stage('Test') {
            steps {
                sh 'phpstan analyse src'
            }
        }
    }
}