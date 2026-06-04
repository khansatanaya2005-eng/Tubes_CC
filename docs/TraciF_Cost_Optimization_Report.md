# TraciF - Cost Optimization & Certification Report
**[Phase 24: Azure Student Edition]**

## 1. Cost Optimization Audit

A comprehensive review of the enterprise architecture was conducted to ensure compliance with the **$100 Azure for Students** limit per semester.

### Previous Unoptimized Architecture Risks:
- **VMs**: Standard_D2s_v3 (Expensive, overkill for basic Laravel app).
- **Storage**: Premium SSDs (High fixed cost).
- **Database**: General Purpose tier, HA enabled, 100GB storage.
- **Credit Consumption Rate**: High risk of depleting the $100 credit within 20-30 days.

### Optimized Student-Friendly Architecture:
- **Resource Group**: `RG-TRACIF-PROD`
- **VMs**: 2x `Standard_B1s` (Burstable, free-tier eligible).
- **Storage**: Standard SSD/HDD.
- **Database**: Azure MySQL Flexible Server `Burstable B1ms` (Development Workload).

---

## 2. Resource Optimization Details

### 2.1 MySQL Cost Optimization
- **Workload**: Development (Disables unnecessary enterprise features).
- **Compute**: Burstable B1ms (1 vCore, 2 GiB RAM).
- **Storage**: 20 GB (Minimum allowed).
- **Backup Retention**: 7 Days.
- **High Availability**: Disabled.
- **Geo-Redundancy**: Disabled.

### 2.2 Virtual Machine Cost Optimization
- **Auto-Shutdown**: Enforced via Azure Portal at **22:00 (Asia/Jakarta)** daily.
- **Impact**: Instead of running 730 hours/month, VMs run approximately 420 hours/month (assuming 08:00 start).
- **Monthly Savings**: ~40% reduction in compute costs per VM.

---

## 3. Monitoring & Budgets

To prevent accidental credit depletion, Azure Cost Management budgets have been defined.

**Budget Configuration:**
- **Scope**: Subscription (Azure for Students).
- **Budget Name**: `TraciF-Semester-Budget`
- **Amount**: $100.00

**Alert Thresholds:**
1. **50% ($50.00)**: Warning - Monitor usage.
2. **75% ($75.00)**: Critical - Prepare for Mode B (Minimal Cost Mode).
3. **90% ($90.00)**: Emergency - Execute Resource Cleanup SOP.

*(Notifications are sent to the primary student email associated with the Azure account).*

---

## 4. Final Cost Certification

### Estimated Projections

| Resource | Unit Cost (Est.) | Qty | Total Monthly (Est.) |
| :--- | :--- | :--- | :--- |
| VM (Standard_B1s) | $7.00 | 2 | $14.00 |
| MySQL (B1ms, 20GB) | $17.94 | 1 | $17.94 |
| Load Balancer | $2.00 | 1 | $2.00 |
| Public IPs & Net | $2.00 | - | $2.00 |
| **Total (Worst Case)** | | | **~ $35.94** |

*Note: Auto-shutdown and Mode B operations will further reduce this to approximately **$15-$20/month**.*

### Semester Cost Projection (4 Months)
- **Worst Case Scenario (24/7 uptime)**: $120.00
- **Best Case Scenario (Auto-shutdown & Mode B)**: $60.00 - $80.00

### Certification Status
✅ **SAFE FOR AZURE STUDENT**
> The projected semester cost remains below $100 when strictly adhering to the Operations Runbook (Mode B for normal days) and Auto-Shutdown schedules.
