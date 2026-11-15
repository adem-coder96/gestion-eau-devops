
# Gestion Eau — PHP DevOps Project

A PHP and MariaDB application for water depot management, containerized with Docker and integrated into an automated CI/CD deployment pipeline.

## 1. Project Overview

This project demonstrates the integration of a PHP application into a DevOps workflow.

The application uses:
- PHP for the backend.
- MariaDB for database management.
- Docker and Docker Compose for containerization.
- GitHub Actions for Continuous Integration and Continuous Delivery.
- Harbor as a local Docker image registry.
- Pyinfra for application deployment.
- Uptime Kuma for application monitoring.

## 2. Architecture

```text
Developer
   |
   v
GitHub Repository
   |
   | Feature branch / Pull Request
   v
GitHub Actions
   |
   | PHP syntax validation
   | Docker image build
   v
Harbor Registry
   |
   | Pull latest image
   v
Pyinfra Deployment
   |
   v
Docker Application Container
   |
   +------ MariaDB Container
   |
   v
Health Endpoint
   |
   v
Uptime Kuma Monitoring
```

## 3. CI/CD Pipeline

The workflow is defined in:

`.github/workflows/ci.yml`

### Feature branch and Pull Request

1. Create a feature branch.
2. Modify the application.
3. Commit and push the changes.
4. Create a Pull Request targeting `main`.
5. GitHub Actions runs the PHP syntax validation.

### Main branch

After merging the Pull Request into `main`:

1. GitHub Actions validates PHP syntax.
2. Docker builds the production image.
3. The image is pushed to Harbor.
4. The image is tagged with `latest` and the short Git commit SHA.

The deployment is then triggered manually by running the Pyinfra deployment script.

The Harbor repository is:

`localhost:80/devops/gestion-eau`

## 4. Deployment with Pyinfra

The deployment configuration is defined in:

`deploy.py`

Pyinfra performs three operations:

1. Pulls the latest PHP application image from Harbor.
2. Recreates the application container without restarting MariaDB.
3. Checks the application container status.

Activate the Python virtual environment:

```bash
source ~/pyinfra-env/bin/activate
```

Execute the deployment:

```bash
pyinfra @local deploy.py
```

## 5. Monitoring with Uptime Kuma

Uptime Kuma monitors the PHP application's health endpoint.

- Dashboard: `http://localhost:3001`
- Monitor name: `Gestion Eau PHP`
- Health endpoint: `http://host.docker.internal:8081/health.php`
- Check interval: 60 seconds
- Retries: 2

The health endpoint returns JSON:

```json
{
  "status": "healthy",
  "version": "step-5-test"
}
```

It returns HTTP 503 if the database connection fails.

## 6. Docker Configuration

The application and database are defined in `compose.yaml`.

Start the services:

```bash
docker compose up -d
```

Check container status:

```bash
docker compose ps
```

View application logs:

```bash
docker compose logs app
```

Stop the services:

```bash
docker compose down
```

The MariaDB data is stored in a persistent Docker volume.

## 7. Useful Verification Commands

Check application health:

```bash
curl http://localhost:8081/health.php
```

Check Docker containers:

```bash
docker ps
```

Check the deployment:

```bash
pyinfra @local deploy.py
```

## 8. GitHub Repository

Source code:

https://github.com/adem-coder96/gestion-eau-devops

CI/CD workflow:

`.github/workflows/ci.yml`

## 9. Project Validation

The following operations were successfully tested:

- PHP syntax validation through GitHub Actions.
- Docker image creation and publication to Harbor.
- Deployment using Pyinfra.
- Application health verification with HTTP 200.
- Uptime Kuma monitoring.
- Detection of application downtime and recovery.

## 10. Technologies

PHP | MariaDB | Docker | Docker Compose | GitHub Actions | Harbor | Pyinfra | Uptime Kuma | Linux | Python
