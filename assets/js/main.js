$(function () {

  var App = {

    //TODO: Find a better way to set these from config.php
    baseUrl : '/ci_sock/part_one/',
    maxCharacters: 320,
    maxPostsPerPage : 5,

    init: function () {
      this.setElements();
      this.bindEvents();
      this.setupComponents();
    },

    // Cache all the jQuery selectors for easy reference.
    setElements: function () {
      this.$messageBox = $('#txtNewMessage');
      this.$numChars = $('#spanNumChars');
      this.$postButton = $('#btnPost');
      this.$myMessages = $('#tblMyMessages tbody');
      this.$newUserButton = $('#btnModalSubmit');
      this.$modalWindow = $('#myModal');
      this.$otherPostAvatars = $('.otherAvatar img');
      this.$tagline = $('#pTagline');
      this.$taglineText = this.$tagline.html();
      this.$totalMessageCount = $('.totalMessageCount');
      this.$messageCount = $('.messageCount');
    },

    // Bind document events and assign event handlers.
    bindEvents: function () {
      this.$messageBox.on('input propertychange', this.updateNumChars);
      this.$postButton.on('click', this.postMessage);
      this.$newUserButton.on('click', this.addNewUser);
      this.$tagline.on('blur',this.saveTagline);
    },

    // Initialize any extra UI components
    setupComponents : function () {
      // Set up the popovers when hovering over another user's avatar.
      this.$otherPostAvatars.popover({
        html:true,
        placement:'left',
        trigger: 'hover'
      });
    },

    /* *************************************
     *             Event Handlers
     * ************************************* */

    /**
     * Click handler for the Create button in
     * the New User modal window. It grabs data
     * from the form and submits it to the
     * create_new_user function in the Main controller.
     *
     * @param e event
     */
    addNewUser : function (e) {
      var formData = {
        firstName : $('#first_name').val(),
        lastName  : $('#last_name').val(),
        email     : $('#email').val(),
        isAdmin   : $('#isAdmin').is(':checked'),
        teamId    : $('#teamId').val(),
        password1 : $('#password').val(),
        password2 : $('#password2').val()
      };
      // TODO: Client-side validation goes here

      var postUrl = App.baseUrl + '/index.php/main/create_new_user';

      $.ajax({
        type: 'POST',
        url: postUrl,
        dataType: 'text',
        data: formData,
        success: App.newUserCreated,
        error: App.alertError
      })

    },

    /**
     * A new user has been created, and the server has responded (or errored)
     * @param response
     */
    newUserCreated : function(response) {
      if ( response ) {
        App.$modalWindow.modal('hide');
      }
      // TODO: if response not true, show server validation errors
    },

    /**
     * Util method for blasting an error message on the screen.
     * @param error
     */
    alertError : function( error ) {
       var args = arguments;
       var msg = error.responseText;
    }

  };

  App.init();

});
