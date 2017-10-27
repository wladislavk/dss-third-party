<template>
    <li
        v-on:mouseover="showChildren = true"
        v-on:mouseout="showChildren = false"
    >
        <a
            v-bind:class="{
                'mainfoldericon': menuItem.children.length && firstLevel,
                'subfoldericon': menuItem.children.length && !firstLevel
            }"
            v-bind:href="menuItem.link ? legacyUrl + menuItem.link : '#'"
            v-on:click="clickLink(menuItem.action, $event)"
            v-bind:target="menuItem.blank ? '_blank' : '_self'"
        >{{ menuItem.name }}</a>
        <ul v-if="menuItem.children.length" v-show="showChildren" v-bind:style="{ left: initialOffset + 'px' }">
            <navigation-element
                v-for="childItem in menuItem.children"
                v-if="resolveCondition(childItem.if)"
                v-bind:menu-item="childItem"
                v-bind:first-level="false"
            ></navigation-element>
        </ul>
        <ul v-else-if="menuItem.childrenFrom" v-show="showChildren" v-bind:style="{ left: initialOffset + 'px' }">
            <li v-for="childFrom in getChildrenFrom(menuItem.childrenFrom)">
                <a class="submenu_item" v-bind:href="legacyUrl + menuItem.link + childFrom[menuItem.childId]">{{ childFrom[menuItem.childName] }}</a>
            </li>
        </ul>
    </li>
</template>

<script src="./NavigationElement.js"></script>
