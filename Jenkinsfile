pipeline {
    agent any

    stages {
        stage('Clone Repository') {
            steps {
                git branch: 'main', url: 'https://github.com/Rosh6413/VMS.git'
            }
        }

        stage('Install Dependencies') {
            steps {
                sh 'sudo apt update && sudo apt install -y apache2 php libapache2-mod-php php-mysql unzip'
            }
        }

        stage('Deploy Application') {
            steps {
                sh '''
                sudo rm -rf /var/www/html/*
                sudo cp -r * /var/www/html/
                sudo systemctl restart apache2
                '''
            }
        }
    }
}

