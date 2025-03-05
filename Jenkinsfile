pipeline {
    agent any

    environment {
        DEBIAN_FRONTEND = "noninteractive"  // Prevent interactive prompts
    }

    stages {
        stage('Clone Repository') {
            steps {
                git branch: 'main', url: 'https://github.com/Rosh6413/VMS.git'
            }
        }

        stage('Install Dependencies') {
            steps {
                script {
                    sh 'sudo apt update'
                    sh 'sudo apt install -y apache2 php php-mysql'
                }
            }
        }

        stage('Build') {
            steps {
                echo 'Building the project...'
                // Add build commands if needed, like:
                // sh 'mvn clean package' (for Java projects)
                // sh 'npm install' (for Node.js projects)
            }
        }

        stage('Deploy') {
            steps {
                script {
                    sh 'sudo cp -r * /var/www/html/'  // Move project files to Apache root
                    sh 'sudo systemctl restart apache2'
                }
                echo 'Deployment completed successfully.'
            }
        }
    }

    post {
        success {
            echo "✅ Build & Deployment Successful!"
        }
        failure {
            echo "❌ Build Failed! Check the logs."
        }
    }
}

