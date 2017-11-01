<template>
    <li
        v-on:mouseover="showChildren = true"
        v-on:mouseout="showChildren = false"
    >
        <a
            v-bind:class="{
                'mainfoldericon': menuItemChildren.length && firstLevel,
                'subfoldericon': menuItemChildren.length && !firstLevel
            }"
            v-bind:href="menuItemLink"
            v-on:click="clickLink($event)"
            v-bind:target="menuItemBlank ? '_blank' : '_self'"
        >{{ menuItem.name }}</a>
        <ul v-if="menuItemChildren.length" v-show="showChildren" v-bind:style="{ left: initialOffset + 'px' }">
            <navigation-element
                v-for="childItem in menuItemChildren"
                v-if="resolveCondition(childItem.if)"
                v-bind:menu-item="childItem"
                v-bind:first-level="false"
                v-bind:key="childItem.name"
            ></navigation-element>
        </ul>
        <ul v-else-if="menuItem.childrenFrom" v-show="showChildren" v-bind:style="{ left: initialOffset + 'px' }">
            <li v-for="childFrom in getChildrenFrom(menuItem.childrenFrom)">
                <a class="submenu_item" v-bind:href="menuItemLink + '/' + childFrom[menuItem.childId]">{{ childFrom[menuItem.childName] }}</a>
            </li>
        </ul>
    </li>
</template>

<script src="./NavigationElement.js"></script>

<style src="../../../assets/css/manage/homesuckertreemenu.css" scoped></style>
