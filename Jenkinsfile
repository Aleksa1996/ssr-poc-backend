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
                }
            }
        }
        stage('Build') {
            steps {
                script {
                    dockerImage = dockerGv.buildImage(dockerImageTarget, dockerImageFile)
                    dockerImage.inside {
                        sh 'php /tools/toolbox list-tools'
                    }
                }
            }
        }
        stage('Test') {
            steps {
                script {
                    dockerImage.inside {
                        sh 'ls'
                        sh 'phpstan analyse src'
                    }
                }
            }
        }
    }
    // post {
    //     cleanup {
    //         cleanWs()
    //     }
    // }
}
