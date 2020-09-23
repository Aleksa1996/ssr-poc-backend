#!/usr/bin/env groovy

node {

    stage('Build') {
        def dockerfile = 'Dockerfile'
        def image = docker.build("my-image:${env.BUILD_ID}", "--target dev .")
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