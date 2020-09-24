def buildImage(target, dockerfile) {
    return docker.build("${target}-app-image:${env.BUILD_ID}", "--target ${target} -f ${dockerfile} .");
}

return this;