<?php
namespace Ptr\Repository\LXC;

use Ptr\Cache\CachePDO;
use Ptr\Database\Database;

class LXCDelete
{
    private array $fields = [];

    function uidEq(string $value): LXCDelete  {
        $this->fields[] = ['field' => 'lxc_uid', 'value' => $value, 'operator' => "="];
        return $this;
    }    function uidNotEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'lxc_uid', 'value' => $value, 'operator' => "<>"];
    return $this;
}    function uidGt(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'lxc_uid', 'value' => $value, 'operator' => ">"];
    return $this;
}    function uidGtEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'lxc_uid', 'value' => $value, 'operator' => ">="];
    return $this;
}    function uidLt(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'lxc_uid', 'value' => $value, 'operator' => "<"];
    return $this;
}    function uidLtEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'lxc_uid', 'value' => $value, 'operator' => "=<"];
    return $this;
}    function uidIn(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'lxc_uid', 'value' => $value, 'operator' => "IN"];
    return $this;
}    function uidNotIn(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'lxc_uid', 'value' => $value, 'operator' => "NOT IN"];
    return $this;
}    function proxmoxLxcIdEq(int $value): LXCDelete  {
    $this->fields[] = ['field' => 'proxmox_lxc_id', 'value' => $value, 'operator' => "="];
    return $this;
}    function proxmoxLxcIdNotEq(int $value): LXCDelete  {
    $this->fields[] = ['field' => 'proxmox_lxc_id', 'value' => $value, 'operator' => "<>"];
    return $this;
}    function proxmoxLxcIdGt(int $value): LXCDelete  {
    $this->fields[] = ['field' => 'proxmox_lxc_id', 'value' => $value, 'operator' => ">"];
    return $this;
}    function proxmoxLxcIdGtEq(int $value): LXCDelete  {
    $this->fields[] = ['field' => 'proxmox_lxc_id', 'value' => $value, 'operator' => ">="];
    return $this;
}    function proxmoxLxcIdLt(int $value): LXCDelete  {
    $this->fields[] = ['field' => 'proxmox_lxc_id', 'value' => $value, 'operator' => "<"];
    return $this;
}    function proxmoxLxcIdLtEq(int $value): LXCDelete  {
    $this->fields[] = ['field' => 'proxmox_lxc_id', 'value' => $value, 'operator' => "=<"];
    return $this;
}    function proxmoxLxcIdIn(int $value): LXCDelete  {
    $this->fields[] = ['field' => 'proxmox_lxc_id', 'value' => $value, 'operator' => "IN"];
    return $this;
}    function proxmoxLxcIdNotIn(int $value): LXCDelete  {
    $this->fields[] = ['field' => 'proxmox_lxc_id', 'value' => $value, 'operator' => "NOT IN"];
    return $this;
}    function parentProxmoxLxcIdEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'parent_proxmox_lxc_id', 'value' => $value, 'operator' => "="];
    return $this;
}    function parentProxmoxLxcIdNotEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'parent_proxmox_lxc_id', 'value' => $value, 'operator' => "<>"];
    return $this;
}    function parentProxmoxLxcIdGt(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'parent_proxmox_lxc_id', 'value' => $value, 'operator' => ">"];
    return $this;
}    function parentProxmoxLxcIdGtEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'parent_proxmox_lxc_id', 'value' => $value, 'operator' => ">="];
    return $this;
}    function parentProxmoxLxcIdLt(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'parent_proxmox_lxc_id', 'value' => $value, 'operator' => "<"];
    return $this;
}    function parentProxmoxLxcIdLtEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'parent_proxmox_lxc_id', 'value' => $value, 'operator' => "=<"];
    return $this;
}    function parentProxmoxLxcIdIn(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'parent_proxmox_lxc_id', 'value' => $value, 'operator' => "IN"];
    return $this;
}    function parentProxmoxLxcIdNotIn(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'parent_proxmox_lxc_id', 'value' => $value, 'operator' => "NOT IN"];
    return $this;
}    function hostnameEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'hostname', 'value' => $value, 'operator' => "="];
    return $this;
}    function hostnameNotEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'hostname', 'value' => $value, 'operator' => "<>"];
    return $this;
}    function hostnameGt(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'hostname', 'value' => $value, 'operator' => ">"];
    return $this;
}    function hostnameGtEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'hostname', 'value' => $value, 'operator' => ">="];
    return $this;
}    function hostnameLt(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'hostname', 'value' => $value, 'operator' => "<"];
    return $this;
}    function hostnameLtEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'hostname', 'value' => $value, 'operator' => "=<"];
    return $this;
}    function hostnameIn(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'hostname', 'value' => $value, 'operator' => "IN"];
    return $this;
}    function hostnameNotIn(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'hostname', 'value' => $value, 'operator' => "NOT IN"];
    return $this;
}    function ipEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'ip', 'value' => $value, 'operator' => "="];
    return $this;
}    function ipNotEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'ip', 'value' => $value, 'operator' => "<>"];
    return $this;
}    function ipGt(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'ip', 'value' => $value, 'operator' => ">"];
    return $this;
}    function ipGtEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'ip', 'value' => $value, 'operator' => ">="];
    return $this;
}    function ipLt(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'ip', 'value' => $value, 'operator' => "<"];
    return $this;
}    function ipLtEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'ip', 'value' => $value, 'operator' => "=<"];
    return $this;
}    function ipIn(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'ip', 'value' => $value, 'operator' => "IN"];
    return $this;
}    function ipNotIn(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'ip', 'value' => $value, 'operator' => "NOT IN"];
    return $this;
}    function enableRecreateEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'enable_recreate', 'value' => $value, 'operator' => "="];
    return $this;
}    function enableRecreateNotEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'enable_recreate', 'value' => $value, 'operator' => "<>"];
    return $this;
}    function enableRecreateGt(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'enable_recreate', 'value' => $value, 'operator' => ">"];
    return $this;
}    function enableRecreateGtEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'enable_recreate', 'value' => $value, 'operator' => ">="];
    return $this;
}    function enableRecreateLt(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'enable_recreate', 'value' => $value, 'operator' => "<"];
    return $this;
}    function enableRecreateLtEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'enable_recreate', 'value' => $value, 'operator' => "=<"];
    return $this;
}    function enableRecreateIn(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'enable_recreate', 'value' => $value, 'operator' => "IN"];
    return $this;
}    function enableRecreateNotIn(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'enable_recreate', 'value' => $value, 'operator' => "NOT IN"];
    return $this;
}    function noBranchEq(bool $value): LXCDelete  {
    $this->fields[] = ['field' => 'no_branch', 'value' => $value, 'operator' => "="];
    return $this;
}    function noBranchNotEq(bool $value): LXCDelete  {
    $this->fields[] = ['field' => 'no_branch', 'value' => $value, 'operator' => "<>"];
    return $this;
}    function noBranchGt(bool $value): LXCDelete  {
    $this->fields[] = ['field' => 'no_branch', 'value' => $value, 'operator' => ">"];
    return $this;
}    function noBranchGtEq(bool $value): LXCDelete  {
    $this->fields[] = ['field' => 'no_branch', 'value' => $value, 'operator' => ">="];
    return $this;
}    function noBranchLt(bool $value): LXCDelete  {
    $this->fields[] = ['field' => 'no_branch', 'value' => $value, 'operator' => "<"];
    return $this;
}    function noBranchLtEq(bool $value): LXCDelete  {
    $this->fields[] = ['field' => 'no_branch', 'value' => $value, 'operator' => "=<"];
    return $this;
}    function noBranchIn(bool $value): LXCDelete  {
    $this->fields[] = ['field' => 'no_branch', 'value' => $value, 'operator' => "IN"];
    return $this;
}    function noBranchNotIn(bool $value): LXCDelete  {
    $this->fields[] = ['field' => 'no_branch', 'value' => $value, 'operator' => "NOT IN"];
    return $this;
}    function typeCodeEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'lxc_type_code', 'value' => $value, 'operator' => "="];
    return $this;
}    function typeCodeNotEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'lxc_type_code', 'value' => $value, 'operator' => "<>"];
    return $this;
}    function typeCodeGt(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'lxc_type_code', 'value' => $value, 'operator' => ">"];
    return $this;
}    function typeCodeGtEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'lxc_type_code', 'value' => $value, 'operator' => ">="];
    return $this;
}    function typeCodeLt(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'lxc_type_code', 'value' => $value, 'operator' => "<"];
    return $this;
}    function typeCodeLtEq(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'lxc_type_code', 'value' => $value, 'operator' => "=<"];
    return $this;
}    function typeCodeIn(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'lxc_type_code', 'value' => $value, 'operator' => "IN"];
    return $this;
}    function typeCodeNotIn(string $value): LXCDelete  {
    $this->fields[] = ['field' => 'lxc_type_code', 'value' => $value, 'operator' => "NOT IN"];
    return $this;
}
}
