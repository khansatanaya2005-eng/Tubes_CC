# TraciF Evidence Collection Guide
**Phase 20.8: Screenshot Checklist for Academic Defense**

The following screenshots are **mandatory** to prove that the architecture and deployment were executed successfully in the real Azure Cloud environment. Save all screenshots into the `docs/images/` directory.

### 1. Azure Infrastructure Evidence
- [ ] `01-resource-group.png`
  - **Purpose**: Proof of isolated cloud environment.
  - **Expected Content**: Azure Portal showing `RG-TRACIF-PROD` with all resources listed.
- [ ] `02-vnet.png`
  - **Purpose**: Proof of network foundation.
  - **Expected Content**: VNet overview showing `10.0.0.0/16`.
- [ ] `03-subnet-lb.png`, `04-subnet-app.png`, `05-subnet-db.png`
  - **Purpose**: Proof of 3-Tier network segregation.
  - **Expected Content**: Subnets blade showing the three `/24` subnets.
- [ ] `06-nsg.png`
  - **Purpose**: Proof of security hardening.
  - **Expected Content**: Inbound rules allowing only port 80/443 from Internet, and port 22 from specific Admin IP.

### 2. Compute & Database Evidence
- [ ] `07-vm-app-01.png` & `08-vm-app-02.png`
  - **Purpose**: Proof of Application Nodes.
  - **Expected Content**: VM Overview pages showing `Standard_B1s` running on the private `10.0.1.0/24` subnet.
- [ ] `09-mysql-flexible-server.png`
  - **Purpose**: Proof of PaaS Database utilization.
  - **Expected Content**: Azure Database for MySQL overview showing private networking and successful connection metrics.

### 3. Application & Deployment Evidence
- [ ] `10-cost-management.png`
  - **Purpose**: Proof of budget awareness.
  - **Expected Content**: Azure Cost Analysis showing forecasted spending < $100.
- [ ] `11-nginx-config.png`
  - **Purpose**: Proof of Load Balancer implementation.
  - **Expected Content**: Terminal screenshot showing `upstream` block in Nginx config.
- [ ] `12-tracif-login.png`
  - **Purpose**: Proof of successful deployment.
  - **Expected Content**: The TraciF login page loaded via the Public IP/Domain.
- [ ] `13-dashboard-analytics.png`
  - **Purpose**: Proof of Business Intelligence features.
  - **Expected Content**: Dashboard showing populated charts and metrics.
- [ ] `14-health-endpoint.png`
  - **Purpose**: Proof of system observability.
  - **Expected Content**: Browser or Postman showing `{ "status": "healthy" }` JSON response.

### 4. High Availability Evidence
- [ ] `15-load-balancer-test.png`
  - **Purpose**: Proof of traffic distribution.
  - **Expected Content**: Nginx access logs on VM1 and VM2 showing traffic being split (Round Robin).
- [ ] `16-failover-test.png`
  - **Purpose**: Proof of High Availability and Database Session resilience.
  - **Expected Content**: Terminal showing VM1 stopped, side-by-side with browser showing the app still functioning perfectly via VM2.
