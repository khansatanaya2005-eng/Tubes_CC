# TraciF High Availability & Failover Test Report
**Phases 21.5 & 21.6: Session Persistence & Failover Validation**

*Status Note: This document is a template awaiting actual physical execution in the Azure Portal. All statuses are currently marked as **PENDING EVIDENCE**.*

---

## 1. Scenario Outline

To prove the robustness of the 3-Tier Architecture, TraciF must survive the sudden catastrophic failure of one Application Node without logging the user out or displaying a 502 Bad Gateway error.

### Prerequisites:
- `SESSION_DRIVER=database` is configured on both VMs.
- Both VMs are actively connected to the Azure MySQL Flexible Server.
- Nginx Load Balancer is configured with an `upstream` block pointing to both VMs.

---

## 2. Session Persistence Test (Phase 21.5)

**Execution Steps**:
1. Open TraciF via the Load Balancer Public IP.
2. Login as `admin`.
3. Force a node switch (or rely on Round Robin on the next request).
4. Verify authentication status.

| Checkpoint | Expected Result | Actual Result |
|------------|-----------------|---------------|
| Login Success | User dashboard loads | ⏳ PENDING |
| Refresh Page | User remains logged in | ⏳ PENDING |
| Database Session Table | `sessions` table has an active record | ⏳ PENDING |

---

## 3. Catastrophic Failover Test (Phase 21.6)

**Execution Steps**:
1. Ensure the user is actively logged in and browsing the Dashboard.
2. SSH into `VM-APP-01`.
3. Execute: `sudo systemctl stop nginx` (Simulating web server crash) OR shut down the VM from Azure Portal.
4. Immediately navigate to the "Produk" page in TraciF.

**Validation Matrix**:

| Verification | Expected Result | Actual Result | Evidence Required |
|--------------|-----------------|---------------|-------------------|
| Web Traffic | LB automatically routes 100% traffic to `VM-APP-02`. | ⏳ PENDING | `16-failover-test.png` |
| Application State | Page loads successfully without 502 errors. | ⏳ PENDING | `16-failover-test.png` |
| Session State | User is **STILL LOGGED IN** (Because session is in DB, not VM1 RAM). | ⏳ PENDING | `16-failover-test.png` |

---

## 4. Test Conclusion

**Status**: ⏳ AWAITING EXECUTION

*(Once executed, replace the PENDING tags with PASSED and embed the screenshot evidence here to finalize the report for academic grading.)*
