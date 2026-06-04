# TraciF High Availability & Failover Test Report
**Phases 21.5 & 21.6: Session Persistence & Failover Validation**

*Status Note: This document has been updated with the live Production Azure Load Balancer IP.*

---

## 1. Scenario Outline

To prove the robustness of the 3-Tier Architecture, TraciF must survive the sudden catastrophic failure of one Application Node without logging the user out or displaying a 502 Bad Gateway error.

### Prerequisites:
- `SESSION_DRIVER=database` is configured on both VMs.
- Both VMs are actively connected to the Azure MySQL Flexible Server.
- **Azure Load Balancer (IP: `4.144.129.216`)** is configured with `BackendPool-TraciF` pointing to both VMs (`VM-APP-01` & `VM-APP-02`).

---

## 2. Session Persistence Test (Phase 21.5)

**Execution Steps**:
1. Open TraciF via the Load Balancer Public IP: `http://4.144.129.216`.
2. Login as `admin`.
3. Force a node switch (or rely on Round Robin on the next request).
4. Verify authentication status.

| Checkpoint | Expected Result | Actual Result |
|------------|-----------------|---------------|
| Login Success | User dashboard loads | ✅ PASSED |
| Refresh Page | User remains logged in | ✅ PASSED |
| Database Session Table | `sessions` table has an active record | ✅ PASSED |

---

## 3. Catastrophic Failover Test (Phase 21.6)

**Execution Steps**:
1. Ensure the user is actively logged in and browsing the Dashboard via `http://4.144.129.216`.
2. Open Azure Portal and navigate to `VM-APP-01`.
3. Click **Stop** to shut down the VM (Simulating a total server crash in Zone 1).
4. Immediately navigate to the "Produk" page or refresh the browser.

**Validation Matrix**:

| Verification | Expected Result | Actual Result |
|--------------|-----------------|---------------|
| Web Traffic | LB automatically routes 100% traffic to `VM-APP-02`. | ✅ PASSED |
| Application State | Page loads successfully without 502/Timeout errors. | ✅ PASSED |
| Session State | User is **STILL LOGGED IN** (Because session is in DB, not VM1 RAM). | ✅ PASSED |

---

## 4. Test Conclusion

**Status**: ✅ **SUCCESSFULLY VALIDATED**

*(The High Availability infrastructure of TraciF is officially verified. The Azure Load Balancer successfully reroutes traffic instantly during a node failure, and centralized database sessions ensure 0% data loss for end-users).*
