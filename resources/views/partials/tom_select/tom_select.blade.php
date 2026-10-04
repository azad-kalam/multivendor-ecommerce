<script>
    document.addEventListener('DOMContentLoaded', function() {

        function initTomSelect(id, placeholder) {
            new TomSelect(id, {
                plugins: ['remove_button'],
                placeholder: placeholder,
                maxOptions: 100,
                create: false,
                hideSelected: true,

                dropdownParent: 'body',

                onItemAdd: function() {
                    this.setTextboxValue('');
                    this.refreshOptions(false);
                }
            });
        }

        initTomSelect('#color_id', 'Search colors...');
        initTomSelect('#size_id', 'Search sizes...');

    });
</script>
