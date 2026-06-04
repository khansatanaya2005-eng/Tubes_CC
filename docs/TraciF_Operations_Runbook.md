# TraciF - Operations & Security Runbook
**[Phase 24: Enterprise Management]**

## 1. Load Balancer Strategy

To maintain Azure Student Credit limits while still fulfilling grading/presentation requirements, two distinct operational modes have been defined.

### MODE A: Presentation Day (High Availability Active)
*Use this mode strictly during project presentations, grading sessions, or failover demonstrations.*

**Configuration:**
- **VM-APP-01**: ON
- **VM-APP-02**: ON
- **Load Balancer**: ON (Routing traffic to both VMs).

**Demonstration Procedure:**
1. Access the Load Balancer Public IP.
2. Log into the Azure Portal and manually STOP `VM-APP-01`.
3. Refresh the application in the browser. It will seamlessly continue running via `VM-APP-02`.

### MODE B: Normal Days (Minimal Cost)
*Use this mode for all other days during the semester to conserve credits.*

**Configuration:**
- **VM-APP-01**: ON
- **VM-APP-02**: OFF (Deallocated).
- **Load Balancer**: LB remains active, but all traffic routes exclusively to VM-APP-01.

**Switching Procedure (A -> B):**
1. Open Azure Portal > Virtual Machines.
2. Select `VM-APP-02` > Click **Stop**.
3. Verify status changes to *Stopped (deallocated)* to stop billing for compute.

---

## 2. Security Hardening Checklist

The following security protocols must be validated within the Azure Portal:

- [ ] **NSG Rules (App Subnet)**: Port 22 (SSH) is strictly limited to the Administrator's Home/Campus IP address. Do NOT leave Source as `Any`.
- [ ] **NSG Rules (App Subnet)**: Port 80 (HTTP) is open to the Internet.
- [ ] **Database Access**: Azure Database for MySQL Networking is set to *Allow public access from Azure services*. Direct external connections are blocked.
- [ ] **Application Access**: Ensure `.env` contains secure, complex passwords. `APP_DEBUG` is set to `false`.

---

## 3. Resource Cleanup SOP

### 3.1 Semester End Procedure
When the semester concludes and the project is officially graded, execute this procedure to prevent unexpected credit card charges upon Azure Student expiration.

1. **Delete Resource Group**: Go to `RG-TRACIF-PROD`, click **Delete resource group**, type the name to confirm, and delete. This wipes the VMs, Load Balancer, VNet, and Database in one action.
2. **Verify Deletion**: Ensure no rogue Public IPs or Disks remain in the `All Resources` tab.

### 3.2 Troubleshooting Rollback Procedures
If the application crashes post-deployment:
1. SSH into the active VM.
2. Check Nginx logs: `sudo tail -f /var/log/nginx/error.log`
3. Check Laravel logs: `tail -f /var/www/tracif/storage/logs/laravel.log`
4. If a recent git pull broke the system: `git checkout HEAD^` and `php artisan optimize:clear`.

---

## 4. Evidence Collection Checklist

For final project submission, capture screenshots of the following Azure Portal interfaces:

- [ ] **Resource Group**: Showing VNet, VMs, LB, and DB.
- [ ] **Virtual Machines**: Showing `VM-APP-01` and `VM-APP-02` running (for Mode A).
- [ ] **Load Balancer**: Backend Pool configuration showing both VMs.
- [ ] **MySQL Flexible Server**: Showing B1ms tier and Networking settings.
- [ ] **Cost Management**: Showing the Budget Alert configuration.
- [ ] **Failover Test**: Screenshot of the app running successfully after VM1 is stopped.
- [ ] **Terminal**: Show `sudo supervisorctl status` displaying the Queue Worker running.
