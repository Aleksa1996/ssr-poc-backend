def sh(command) {
    return new ProcessBuilder( 'sh', '-c', command).redirectErrorStream(true).start().text
}

def buildImage(target, dockerfile) {
    return sh('docker container build -t ${target}-app-image:${env.BUILD_ID} --target ${target} -f ${dockerfile} .')
}

return this;